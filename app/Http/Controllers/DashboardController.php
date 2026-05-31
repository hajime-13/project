<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers  = User::count();
        $totalOrders = Order::where('user_id', Auth::id())->count();

        // Orders by status for the logged-in user
        $ordersByStatus = Order::where('user_id', Auth::id())
            ->selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status');

        // Orders per month (last 6 months) for the logged-in user
        $ordersPerMonth = Order::where('user_id', Auth::id())
            ->selectRaw("strftime('%Y-%m', created_at) as month, count(*) as count")
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $recentOrders = Order::where('user_id', Auth::id())
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalUsers',
            'totalOrders',
            'ordersByStatus',
            'ordersPerMonth',
            'recentOrders'
        ));
    }
}
