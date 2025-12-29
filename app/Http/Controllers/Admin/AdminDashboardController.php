<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BookOrder;
use App\Models\Course;
use App\Models\CourseRegistration;
use App\Models\CourseRegistrationInstallment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    /**
     * Show the admin dashboard.
     */
    public function index()
    {
        // Book Orders Analytics
        $bookOrdersStats = [
            'total' => BookOrder::count(),
            'total_revenue' => BookOrder::sum('total_amount'),
            'pending' => BookOrder::where('status', 'pending')->count(),
            'processing' => BookOrder::where('status', 'processing')->count(),
            'shipped' => BookOrder::where('status', 'shipped')->count(),
            'delivered' => BookOrder::where('status', 'delivered')->count(),
            'cancelled' => BookOrder::where('status', 'cancelled')->count(),
            'today_orders' => BookOrder::whereDate('created_at', today())->count(),
            'today_revenue' => BookOrder::whereDate('created_at', today())->sum('total_amount'),
            'this_month_orders' => BookOrder::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)->count(),
            'this_month_revenue' => BookOrder::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)->sum('total_amount'),
        ];

        // Course Registrations Analytics
        $courseRegistrationsStats = [
            'total' => CourseRegistration::count(),
            'online' => CourseRegistration::where('enrollment_type', 'online')->count(),
            'offline' => CourseRegistration::where('enrollment_type', 'offline')->count(),
            'pending' => CourseRegistration::where('status', 'pending')->count(),
            'confirmed' => CourseRegistration::where('status', 'confirmed')->count(),
            'completed' => CourseRegistration::where('status', 'completed')->count(),
            'cancelled' => CourseRegistration::where('status', 'cancelled')->count(),
            'today_registrations' => CourseRegistration::whereDate('created_at', today())->count(),
            'this_month_registrations' => CourseRegistration::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)->count(),
        ];

        // Installments Analytics
        $installmentsStats = [
            'total' => CourseRegistrationInstallment::count(),
            'pending' => CourseRegistrationInstallment::where('status', 'pending')->count(),
            'paid' => CourseRegistrationInstallment::where('status', 'paid')->count(),
            'overdue' => CourseRegistrationInstallment::where('status', 'pending')
                ->where('due_date', '<', now()->startOfDay())->count(),
            'due_today' => CourseRegistrationInstallment::where('status', 'pending')
                ->whereDate('due_date', today())->count(),
            'total_amount' => CourseRegistrationInstallment::sum('amount'),
            'paid_amount' => CourseRegistrationInstallment::where('status', 'paid')->sum('amount'),
            'pending_amount' => CourseRegistrationInstallment::where('status', 'pending')->sum('amount'),
            'overdue_amount' => CourseRegistrationInstallment::where('status', 'pending')
                ->where('due_date', '<', now()->startOfDay())->sum('amount'),
        ];

        // Recent Book Orders
        $recentBookOrders = BookOrder::with('book')
            ->latest()
            ->limit(5)
            ->get();

        // Recent Course Registrations
        $recentCourseRegistrations = CourseRegistration::with('course')
            ->latest()
            ->limit(5)
            ->get();

        // Recent Installments (Overdue and Due Today)
        $recentInstallments = CourseRegistrationInstallment::with('courseRegistration.course')
            ->where(function ($query) {
                $query->where('status', 'pending')
                    ->where(function ($q) {
                        $q->where('due_date', '<', now()->startOfDay())
                            ->orWhereDate('due_date', today());
                    });
            })
            ->orderBy('due_date', 'asc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'bookOrdersStats',
            'courseRegistrationsStats',
            'installmentsStats',
            'recentBookOrders',
            'recentCourseRegistrations',
            'recentInstallments'
        ));
    }
}
