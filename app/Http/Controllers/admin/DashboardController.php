<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $admin = $request->user();

        $stats = [
            'total_users' => User::where('role', 'user')->count(),
            'active_users' => User::where('role', 'user')
                ->where('is_active', true)->count(),
            'inactive_users' => User::where('role', 'user')
                ->where('is_active', false)->count(),
        ];

        return view('admin.dashboard', compact('admin', 'stats'));
    }
}
