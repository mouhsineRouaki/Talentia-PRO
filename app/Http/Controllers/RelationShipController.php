<?php

namespace App\Http\Controllers;
use App\Models\RelationShip;
use App\Models\User;
use App\Models\Notification;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\FriendShipStatu;
use App\Events\NotificationCreated;

class RelationShipController extends Controller
{
    public function AjouteAmi(Request $request)
    {
        $reciever_id = $request->input('reciever_id');

        // verification si le même
        if ($reciever_id == auth()->id()) {
            return redirect()->route('users.search')
                ->with('error', 'Vous ne pouvez pas vous ajouter comme ami');
        }
        // verification du damnade existe déjà
        $existing = RelationShip::where('sender_id',auth()->id())
            ->where('reciever_id', $reciever_id)
            ->first();
        if ($existing) {
            if ($existing->status === 'PENDING') {
                return redirect()->route('users.search')
                    ->with('info', 'Demande d\'ami déjà envoyée.');
            } elseif ($existing->status === 'ACCEPTED') {
                return redirect()->route('users.search')
                    ->with('info','Vous etes déjà amis avec cette personne');
            }
        }

        $relationship = RelationShip::firstOrCreate([
            'sender_id' => auth()->id(),
            'reciever_id' => $reciever_id,
        ], [
            'status' => 'PENDING'
        ]);

        $notification = Notification::create([
            'user_id' => $reciever_id,
            'relationships_id' => $relationship->id,
            'contenu' => auth()->user()->prenom . ' ' . auth()->user()->nom . " vous a envoyé une demande d'amitié.",
            'date_envoyer' => now(),
        ]);

        event(new NotificationCreated($notification));

        return redirect()->route('users.search')->with('success', 'Demande d\'ami envoyée avec succès!');
    }
    public function friendsPage(Request $request)
    {
        $me = $request->user();
        $q = trim((string) $request->query('q', ''));

        $received = RelationShip::query()
            ->where('status', 'PENDING')
            ->where('reciever_id', $me->id)
            ->with('sender:id,nom,prenom,email,role,biographie,image')
            ->latest()
            ->get()
            ->map(fn($rel) => $rel->sender)
            ->filter();

        $sent = RelationShip::query()
            ->where('status', 'PENDING')
            ->where('sender_id', $me->id)
            ->with('reciever:id,nom,prenom,email,role,biographie,image')
            ->latest()
            ->get()
            ->map(fn($rel) => $rel->reciever)
            ->filter();

        $friendIds = RelationShip::query()
            ->where('status', 'ACCEPTED')
            ->where(function ($x) use ($me) {
                $x->where('sender_id', $me->id)
                    ->orWhere('reciever_id', $me->id);
            })
            ->get()
            ->map(fn($rel) => $rel->sender_id == $me->id ? $rel->reciever_id : $rel->sender_id)
            ->unique()
            ->values()
            ->all();

        $friends = User::query()
            ->select('id', 'nom', 'prenom', 'email', 'role', 'biographie', 'image')
            ->whereIn('id', $friendIds)
            ->orderBy('nom')
            ->get();

        if ($q !== '') {
            $filterFn = fn($u) =>
                str_contains(mb_strtolower($u->nom ?? ''), mb_strtolower($q)) ||
                str_contains(mb_strtolower($u->prenom ?? ''), mb_strtolower($q));

            $received = $received->filter($filterFn)->values();
            $sent = $sent->filter($filterFn)->values();
            $friends = $friends->filter($filterFn)->values();
        }

        return view('relationships.friends',compact('received', 'sent', 'friends', 'q'));
    }
    public function accepter(Request $request)
    {
        $sender_id = $request->input('sender_id');
        $reciever_id = $request->input('reciever_id');

        $sender = User::find($sender_id);
        $reciever = User::find($reciever_id);

        $amisS = $sender->amis ?? [];
        $amisR = $reciever->amis ?? [];

        if (!in_array($reciever_id, $amisS)) {
            $amisS[] = $reciever_id;
            $sender->amis = $amisS;
            $sender->save();
        }

        if (!in_array($sender_id, $amisR)) {
            $amisR[] = $sender_id;
            $reciever->amis = $amisR;
            $reciever->save();
        }

        RelationShip::where('sender_id', $sender_id)->where('status', 'PENDING')->where('reciever_id', $reciever_id)->update(['status' => 'ACCEPTED']);

        $notification = Notification::create([
            'user_id' => $sender_id,
            'contenu' => auth()->user()->prenom . ' ' . auth()->user()->nom . " a accepté votre demande d'amitié.",
            'date_envoyer' => now(),
        ]);

        event(new NotificationCreated($notification));

        return redirect()->route('friends.index')->with('success', 'Demande d\'ami acceptée! Vous êtes maintenant amis.');
    }
    public function refuser(Request $request)
    {
        $sender_id = $request->input('sender_id');
        $reciever_id = $request->input('reciever_id');

        RelationShip::where('sender_id', $sender_id)->where('status', 'PENDING')->where('reciever_id', $reciever_id)->update(['status' => 'REFUSED']);
        return redirect()->route('friends.index')->with('warning','Demande d\'ami refusée.');
    }
}
