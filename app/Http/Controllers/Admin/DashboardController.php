<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index()
    {
        // Get stats for the dashboard
        $totalStores = Store::count();
        $totalUsers = User::count();
        $recentStores = Store::latest()->take(5)->get();

        return view('admin.dashboard', [
            'totalStores' => $totalStores,
            'totalUsers' => $totalUsers,
            'recentStores' => $recentStores,
        ]);
    }
} 