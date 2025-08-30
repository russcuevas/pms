<?php

namespace App\Http\Controllers\tenant\jjs1;

use App\Http\Controllers\Controller;
use App\Models\TenantNotification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
        public function TenantsJjs1MarkViewedNotifications($id)
    {
        $notification = TenantNotification::findOrFail($id);

        if ($notification->is_view == 0) {
            $notification->is_view = 1;
            $notification->save();
        }

        return redirect($notification->url);
    }

    public function TenantsJjs1DeleteNotification($id)
{
    $notification = TenantNotification::findOrFail($id);
    $notification->delete();

    return back()->with('success', 'Notification deleted successfully.');
}
}
