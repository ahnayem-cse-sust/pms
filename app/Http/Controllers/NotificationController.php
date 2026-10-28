<?php

namespace App\Http\Controllers;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = auth()->user()->notifications()->paginate(25);
        return view('notifications.index', compact('notifications'));
    }

    /** Polled by every open page: the unread count plus the notifications that arrived since the last poll. */
    public function poll(\Illuminate\Http\Request $r)
    {
        $u = auth()->user();
        $since = \Illuminate\Support\Carbon::createFromTimestamp((int) $r->query('since', now()->timestamp));
        $items = $u->unreadNotifications()->where('created_at', '>=', $since)->latest()->limit(10)->get()
            ->map(fn ($n) => ['id' => $n->id, 'message' => $n->data['message'] ?? '', 'url' => route('notifications.read', $n->id)])->values();

        return response()->json(['unread' => $u->unreadNotifications()->count(), 'items' => $items, 'now' => now()->timestamp])
            ->header('Cache-Control', 'no-store');
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
