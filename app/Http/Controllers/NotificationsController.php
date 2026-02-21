<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification;
use Illuminate\Support\Facades\Cache;

class NotificationsController extends Controller
{
    public function index()
    {
        $userId = auth()->id();
        // le cache pour 5 min
        $notifications = Cache::remember("notifications-{$userId}", 300, function() {
            return auth()->user()->notifications()
                ->latest()
                ->get();
        });
        return view('notifications.index', compact('notifications'));
    }

    public function markAsRead($id)
    {
        $notification = Notification::where('id',$id)
            ->where('user_id', auth()->id())
            ->firstOrFail();
        $notification->update(['is_read' => true]);
        Cache::forget("notifications-" . auth()->id());       // invalider le cache
        return back()->with('success', 'les notification sont marquée comme lue.');
    }

    public function markAllAsRead()
    {
        $count = auth()->user()->notifications()
            ->where('is_read', false)
            ->update(['is_read' => true]);
        Cache::forget("notifications-" . auth()->id());

        if ($count > 0) {
            return back()->with('success', "{$count} notifications marquée comme lues");
        }

        return back()->with('info', 'les notifications sont déjà lues.');
    }

    public function delete($id)
    {
        $notification = Notification::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $notification->delete();
        Cache::forget("notifications-" . auth()->id());
        return back()->with('warning', 'Notification supprimée.');
    }

    public function deleteAll()
    {
        $count = auth()->user()->notifications()->count();

        if ($count > 0) {
            auth()->user()->notifications()->delete();
            Cache::forget("notifications-" . auth()->id());
            return back()->with('success', "les notifications ont été supprimées.");
        }

        return back()->with('info', 'aucune notification à supprimer.');
    }
}