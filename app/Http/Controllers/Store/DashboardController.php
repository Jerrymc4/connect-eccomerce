<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Show the store dashboard.
     *
     * @param Store $store
     * @return \Illuminate\View\View
     */
    public function index(Store $store)
    {
        // Ensure the user has access to this store
        if ($store->owner_id !== Auth::id()) {
            abort(403);
        }

        return view('store.dashboard', compact('store'));
    }
} 