<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminNotificationController extends Controller
{
    /**
     * Display the main notifications page
     */
    public function index(Request $request)
    {
        $query = Notification::where('notifiable_type', User::class)
            ->where('notifiable_id', Auth::id())
            ->orderBy('created_at', 'desc');

        // Apply filters
        if ($request->filled('status')) {
            if ($request->status === 'unread') {
                $query->where('is_read', false);
            } elseif ($request->status === 'read') {
                $query->where('is_read', true);
            }
        }

        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        if ($request->filled('type')) {
            $types = explode(',', $request->type);
            if (count($types) > 1) {
                $query->whereIn('type', $types);
            } else {
                $query->where('type', $request->type);
            }
        }

        if ($request->filled('date_range')) {
            switch ($request->date_range) {
                case 'today':
                    $query->whereDate('created_at', today());
                    break;
                case 'week':
                    $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                    break;
                case 'month':
                    $query->whereMonth('created_at', now()->month)
                          ->whereYear('created_at', now()->year);
                    break;
            }
        }

        $notifications = $query->paginate(20);

        // Get notification counts by type for tabs
        $counts = [
            'all' => Notification::where('notifiable_type', User::class)
                ->where('notifiable_id', Auth::id())->count(),
            'unread' => Notification::where('notifiable_type', User::class)
                ->where('notifiable_id', Auth::id())
                ->where('is_read', false)->count(),
            'company' => Notification::where('notifiable_type', User::class)
                ->where('notifiable_id', Auth::id())
                ->whereIn('type', ['appointment_created', 'pre_employment_created', 'patient_registered'])
                ->count(),
            'nurse' => Notification::where('notifiable_type', User::class)
                ->where('notifiable_id', Auth::id())
                ->whereIn('type', ['checklist_completed', 'annual_physical_created'])
                ->count(),
            'pathologist' => Notification::where('notifiable_type', User::class)
                ->where('notifiable_id', Auth::id())
                ->where('type', 'pathologist_report_submitted')
                ->count(),
            'radtech' => Notification::where('notifiable_type', User::class)
                ->where('notifiable_id', Auth::id())
                ->where('type', 'xray_completed')
                ->count(),
            'radiologist' => Notification::where('notifiable_type', User::class)
                ->where('notifiable_id', Auth::id())
                ->where('type', 'xray_interpreted')
                ->count(),
            'ecgtech' => Notification::where('notifiable_type', User::class)
                ->where('notifiable_id', Auth::id())
                ->where('type', 'ecg_completed')
                ->count(),
            'plebo' => Notification::where('notifiable_type', User::class)
                ->where('notifiable_id', Auth::id())
                ->where('type', 'specimen_collected')
                ->count(),
            'doctor' => Notification::where('notifiable_type', User::class)
                ->where('notifiable_id', Auth::id())
                ->where('type', 'examination_updated')
                ->count(),
        ];

        return view('admin.notifications', compact('notifications', 'counts'));
    }

    /**
     * Get unread notification count for header
     */
    public function getCount()
    {
        $count = Notification::where('notifiable_type', User::class)
            ->where('notifiable_id', Auth::id())
            ->where('is_read', false)
            ->count();

        return response()->json(['count' => $count]);
    }

    /**
     * Get recent notifications for dropdown
     */
    public function getRecent()
    {
        $notifications = Notification::where('notifiable_type', User::class)
            ->where('notifiable_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get()
            ->map(function ($notification) {
                return [
                    'id' => $notification->id,
                    'type' => $notification->type,
                    'title' => $notification->title,
                    'message' => $notification->message,
                    'priority' => $notification->priority,
                    'is_read' => $notification->is_read,
                    'time_ago' => $notification->time_ago,
                    'created_at' => $notification->created_at->format('Y-m-d H:i:s')
                ];
            });

        return response()->json(['notifications' => $notifications]);
    }

    /**
     * Mark a notification as read
     */
    public function markAsRead($id)
    {
        $notification = Notification::where('notifiable_type', User::class)
            ->where('notifiable_id', Auth::id())
            ->findOrFail($id);

        $notification->markAsRead();

        return response()->json(['success' => true]);
    }

    /**
     * Mark all notifications as read
     */
    public function markAllAsRead()
    {
        Notification::where('notifiable_type', User::class)
            ->where('notifiable_id', Auth::id())
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => now()
            ]);

        return response()->json(['success' => true]);
    }

    /**
     * Delete a notification
     */
    public function destroy($id)
    {
        $notification = Notification::where('notifiable_type', User::class)
            ->where('notifiable_id', Auth::id())
            ->findOrFail($id);

        $notification->delete();

        return response()->json(['success' => true]);
    }
}
