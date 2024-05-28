<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function markAsRead($id)
    {
        $notification = Notification::find($id);

        if ($notification && $notification->status !== 'read') {
            $notification->status = 'read';
            $notification->save();
        }

        return redirect($notification->link);
    }
}
