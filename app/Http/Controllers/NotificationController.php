<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;



use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $notifications = Notification::where('notifiable_type', 'App\Models\User')
            ->where('notifiable_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('notifications.index', compact('notifications'));
    }

    public function marquerCommeLu($id)
    {
        $notification = \App\Models\Notification::findOrFail($id);

        if ($notification->notifiable_id !== auth()->id()) {
            abort(403);
        }

        $notification->delete();

        return back()->with('success', 'Notification supprimée.');
    }


    public function marquerToutCommeLu()
    {
        \App\Models\Notification::where('notifiable_type', 'App\Models\User')
            ->where('notifiable_id', auth()->id())
            ->whereNull('read_at')
            ->delete();

        return back()->with('success', 'Toutes les notifications ont été supprimées.');
    }


}
