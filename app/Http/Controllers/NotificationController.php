<?php

namespace App\Http\Controllers;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = auth()->user()->notifications()->paginate(25);
        return view('notifications.index', compact('notifications'));
    }

    public function read(string $id)
    {
        $n = auth()->user()->notifications()->findOrFail($id);
        $n->markAsRead();
        return redirect()->route('tickets.show', $n->data['ticket_id']);
    }

    public function readAll()
    {
        auth()->user()->unreadNotifications->markAsRead();
        return back();
    }
}
