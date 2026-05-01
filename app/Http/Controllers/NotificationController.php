<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class NotificationController extends Controller
{
    public function unreadCount(): Response
    {
        $count = Auth::user()->unreadNotifications()->count();

        return response()->json([
            'unread' => $count,
        ]);
    }

    public function index(): View
    {
        $notifications = Auth::user()->notifications()->latest()->paginate(10);

        return view('notifications.index', compact('notifications'));
    }

    public function markAllAsRead(): RedirectResponse
    {
        Auth::user()->unreadNotifications->markAsRead();

        return Redirect::route('notifications.index');
    }
}
