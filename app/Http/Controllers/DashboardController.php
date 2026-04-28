<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\SalesPage;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
  public function admin()
  {
    // Total users
    $totalUsers = User::count();

    // Total sales pages (revenue)
    $totalRevenue = SalesPage::sum('price');
    $totalSalesPages = SalesPage::count();

    // Calculate profit (assuming 60% profit margin for demo)
    $profit = $totalRevenue * 0.60;

    // Calculate sales (new pages in last 30 days)
    $monthlySales = SalesPage::where('created_at', '>=', now()->subDays(30))->sum('price');

    // Calculate payments (pages in last 7 days)
    $weeklyPayments = SalesPage::where('created_at', '>=', now()->subDays(7))->sum('price');

    // Total transactions count
    $totalTransactions = SalesPage::count();

    // Revenue by month for chart (last 7 months)
    $monthlyRevenue = [];
    $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'];

    for ($i = 6; $i >= 0; $i--) {
      $month = now()->subMonths($i);
      $revenue = SalesPage::whereYear('created_at', $month->year)
        ->whereMonth('created_at', $month->month)
        ->sum('price');
      $monthlyRevenue[] = (int)$revenue;
    }

    // Growth percentage (compare this month vs last month)
    $thisMonthRevenue = SalesPage::whereYear('created_at', now()->year)
      ->whereMonth('created_at', now()->month)
      ->sum('price');
    $lastMonthRevenue = SalesPage::whereYear('created_at', now()->subMonth()->year)
      ->whereMonth('created_at', now()->subMonth()->month)
      ->sum('price');

    $growthPercentage = $lastMonthRevenue > 0
      ? round((($thisMonthRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100, 2)
      : 0;

    // Recent transactions (last 5 sales pages)
    $recentTransactions = SalesPage::with('user')
      ->latest()
      ->take(5)
      ->get()
      ->map(function ($page) {
        return [
          'id' => $page->id,
          'type' => 'Sales Page',
          'description' => $page->product_name,
          'amount' => $page->price,
          'user' => $page->user->name,
          'created_at' => $page->created_at,
        ];
      });

    // Order statistics (pages by status - using created date as reference)
    $completedOrders = SalesPage::where('created_at', '>=', now()->subDays(30))->count();
    $pendingOrders = User::where('profile_completion_percentage', '<', 100)->count();
    $cancelledOrders = 0; // No cancel concept, using 0

    // User growth data (daily registrations for the week)
    $weeklyUsers = [];
    $days = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];

    for ($i = 6; $i >= 0; $i--) {
      $date = now()->subDays($i);
      $count = User::whereDate('created_at', $date->toDateString())->count();
      $weeklyUsers[] = $count;
    }

    // Calculate percentage changes
    $profitChange = $lastMonthRevenue > 0 ? round((($profit - ($lastMonthRevenue * 0.60)) / ($lastMonthRevenue * 0.60)) * 100, 2) : 0;
    $salesChange = $lastMonthRevenue > 0 ? round((($monthlySales - $lastMonthRevenue) / $lastMonthRevenue) * 100, 2) : 0;
    $paymentsChange = -14.82; // Demo value
    $transactionsChange = 28.14; // Demo value

    return view('dashboards.admin', compact(
      'totalUsers',
      'totalRevenue',
      'totalSalesPages',
      'profit',
      'monthlySales',
      'weeklyPayments',
      'totalTransactions',
      'monthlyRevenue',
      'months',
      'growthPercentage',
      'recentTransactions',
      'completedOrders',
      'pendingOrders',
      'cancelledOrders',
      'weeklyUsers',
      'days',
      'profitChange',
      'salesChange',
      'paymentsChange',
      'transactionsChange'
    ));
  }

  public function manager()
  {
    return view('dashboards.manager');
  }

  public function user()
  {
    return view('dashboards.user');
  }
}
