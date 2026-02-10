<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Message;
use App\Events\MessageSent;

class ChatController extends Controller
{
    public function index(Request $request)
    {
        $userId = auth()->id();
        $conversations = Conversation::where('user_one_id', $userId)
            ->orWhere('user_two_id', $userId)
            ->with(['userOne', 'userTow']) 
            ->get();

        $selected_user = null;
        return view('chat.index', compact('conversations', 'selected_user'));
    }

    public function show(Request $request, $id)
    {
        $userId = auth()->id();
        $conversations = Conversation::where('user_one_id', $userId)
            ->orWhere('user_two_id', $userId)
            ->with(['userOne', 'userTow'])
            ->get();

        $conversation = Conversation::with(['message', 'userOne', 'userTow'])->findOrFail($id);

        if ($conversation->user_one_id != $userId && $conversation->user_two_id != $userId) {
            abort(403);
        }

        $selected_user = ($conversation->user_one_id == $userId) ? $conversation->userTow : $conversation->userOne;

        $messages = $conversation->message()->orderBy('created_at', 'asc')->get();

        return view('chat.index', compact('conversations', 'selected_user', 'messages', 'conversation'));
    }


    public function startConvertation(Request $request){
        $authId = auth()->id();

        $data = $request->validate([
            'resever_user_id' => ['required', 'integer', 'exists:users,id'],
        ]);

        $reserver_id = $data['resever_user_id'];

        $userOne = min($reserver_id , $authId);
        $userTow = max($reserver_id,$authId);

        $conversation = Conversation::firstOrCreate([
            'user_one_id' => $userOne,
            'user_two_id' => $userTow,
        ]);

        return redirect()->route('chat.show', ['id' => $conversation->id]);
    }

    public function fetchMessage($id)
    {
        $userId = auth()->id();

        $conversation = Conversation::whereIn('user_one_id', [$userId, $id])
        ->whereIn('user_two_id', [$userId, $id])
        ->first();

        if (!$conversation) {
            return response()->json([]);
        }

        $messages = $conversation->message()->orderBy('created_at', 'asc')->get();

        return response()->json($messages);
    }

    public function sendMessage(Request $request){
        $request->validate([
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc',
            'message' => 'nullable|string',
            'conversation_id' => 'required|exists:conversation,id',
        ]);

        $senderId = auth()->id();
        $conversation = Conversation::findOrFail($request->conversation_id);

        if ($conversation->user_one_id != $senderId && $conversation->user_two_id != $senderId) {
            abort(403);
        }
        $atachmentPath = null;
        $atachementArray = null;
        if($request->hasFile('attachment')){
            $atachmentPath = $request->file('attachment')->store('attachments', 'public');
            $atachementArray = [
                'filename' => $request->file('attachment')->getClientOriginalName(),
                'path' => $atachmentPath,
                'mime_type' => $request->file('attachment')->getClientMimeType(),
                'size' => $request->file('attachment')->getSize(),
            ];
        }

        $message = Message::create([
            'sender_id' => $senderId,
            'conversation_id' => $conversation->id,
            'text' => $request->message,
            'attach' => $atachementArray,

        ]);

        event(new MessageSent($message));

        return response()->json([
            'success' => true,
            'message' => $message,
        ]);
    }
}
