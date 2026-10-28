<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\VisaApplication;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_applications' => VisaApplication::count(),
            'pending'            => VisaApplication::where('status', 'pending')->count(),
            'approved'           => VisaApplication::where('status', 'approved')->count(),
            'rejected'           => VisaApplication::where('status', 'rejected')->count(),
            'total_users'        => User::where('role', 'user')->count(),
            'total_payments'     => 0,
            'pending_docs'       => 0,
            'pending_payments'   => 0,
        ];

        $recent_applications = VisaApplication::with('user')->latest()->take(8)->get();
        $recent_payments = collect();

        return view('admin.dashboard', compact('stats', 'recent_applications', 'recent_payments'));
    }
}