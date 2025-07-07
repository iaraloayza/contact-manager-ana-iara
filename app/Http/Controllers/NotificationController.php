<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class NotificationController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        $notifications = $user->notifications()
            ->orderBy('created_at', 'desc')
            ->get();
            
        $unreadCount = $user->unreadNotifications()->count();
        
        return Inertia::render('Notifications/Index', [
            'notifications' => [
                'data' => $notifications
            ],
            'unreadCount' => $unreadCount,
            'unreadNotifications' => $unreadCount // Para o layout
        ]);
    }
    
    public function markAsRead($notificationId)
    {
        $notification = auth()->user()->notifications()->findOrFail($notificationId);
        $notification->markAsRead();
        
        return back();
    }
    
    public function markAllAsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();
        
        return back();
    }

    public function markAsUnread($notificationId)
    {
        $notification = auth()->user()->notifications()->findOrFail($notificationId);
        $notification->update(['read_at' => null]);
        
        return back();
    }
}