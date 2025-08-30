<?php

namespace App\Http\Controllers\tenant\jjs2;

use App\Http\Controllers\Controller;
use App\Models\TenantNotification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
            public function TenantsJjs2MarkViewedNotifications($id)
    {
        $notification = TenantNotification::findOrFail($id);

        if ($notification->is_view == 0) {
            $notification->is_view = 1;
            $notification->save();
        }

        return redirect($notification->url);
    }

    public function TenantsJjs2DeleteNotification($id)
{
    $notification = TenantNotification::findOrFail($id);
    $notification->delete();

    return back()->with('success', 'Notification deleted successfully.');
}
}
