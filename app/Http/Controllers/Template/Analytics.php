<?php

namespace App\Http\Controllers\Template;

use Auth;
use App\Models\Trip;
use App\Models\User;
use App\Models\Wallet;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Shipment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Analytics extends Controller
{

  public function index()
  {
    $total = User::where('role', 'driver')->count();
    $this_month = User::where('role', 'driver')->whereMonth('created_at', now()->month)->count();
    $last_month = User::where('role', 'driver')->whereMonth('created_at', now()->subMonth(1)->month)->count();
    $percentageChange = number_format(($this_month - $last_month) / max($last_month,1) * 100 , 0);
    $percentageClass = $percentageChange >= 0 ? 'success' : 'danger';
    $active = User::where('role', 'driver')->whereDoesntHave('statuses')->count();
    $activePercentage = number_format(($total > 0 ? ($active / $total) : 0) * 100, 0);

    $driverStats = [
      'total' => $total,
      'monthly' => $this_month,
      'percentageChange' => $percentageChange,
      'percentageClass' => $percentageClass,
      'percentageIcon' => $percentageClass == 'success' ? 'up-arrow-alt' : 'down-arrow-alt',
      'progressPercentage' => $activePercentage,
      'progressMessage' => __('dashboard.progress_active_percentage', ['percentage' => $activePercentage])
    ];

    $total = User::where('role', 'renter')->count();
    $this_month = User::where('role', 'renter')->whereMonth('created_at', now()->month)->count();
    $last_month = User::where('role', 'renter')->whereMonth('created_at', now()->subMonth(1)->month)->count();
    $percentageChange = number_format(($this_month - $last_month) / max($last_month,1) * 100 , 0);
    $percentageClass = $percentageChange >= 0 ? 'success' : 'danger';
    $active = User::where('role', 'renter')->whereDoesntHave('statuses')->count();
    $activePercentage = number_format(($total > 0 ? ($active / $total) : 0) * 100, 0);

    $renterStats = [
      'total' => $total,
      'monthly' => $this_month,
      'percentageChange' => $percentageChange,
      'percentageClass' => $percentageClass,
      'percentageIcon' => $percentageClass == 'success' ? 'up-arrow-alt' : 'down-arrow-alt',
      'progressPercentage' => $activePercentage,
      'progressMessage' => __('dashboard.progress_active_percentage', ['percentage' => $activePercentage])
    ];

    $total = Trip::count();
    $this_month = Trip::whereMonth('created_at', now()->month)->count();
    $last_month = Trip::whereMonth('created_at', now()->subMonth(1)->month)->count();
    $percentageChange = number_format(($this_month - $last_month) / max($last_month,1) * 100 , 0);
    $percentageClass = $percentageChange >= 0 ? 'success' : 'danger';
    $completed = Trip::whereHas('status', fn ($query) => $query->where('name','completed'))->count();
    $completedPercentage = number_format(($total > 0 ? ($completed / $total) : 0) * 100, 0);

    $tripStats = [
      'total' => $total,
      'monthly' => $this_month,
      'percentageChange' => $percentageChange,
      'percentageClass' => $percentageClass,
      'percentageIcon' => $percentageClass == 'success' ? 'up-arrow-alt' : 'down-arrow-alt',
      'progressPercentage' => $completedPercentage,
      'progressMessage' => __('dashboard.progress_completed_percentage', ['percentage' => $completedPercentage])
    ];

    $total = Shipment::count();
    $this_month = Shipment::whereMonth('created_at', now()->month)->count();
    $last_month = Shipment::whereMonth('created_at', now()->subMonth(1)->month)->count();
    $percentageChange = number_format(($this_month - $last_month) / max($last_month,1) * 100 , 0);
    $percentageClass = $percentageChange >= 0 ? 'success' : 'danger';
    $completed = Shipment::whereHas('status', fn ($query) => $query->where('name','delivered'))->count();
    $completedPercentage = number_format(($total > 0 ? ($completed / $total) : 0) * 100, 0);

    $shipmentStats = [
      'total' => $total,
      'monthly' => $this_month,
      'percentageChange' => $percentageChange,
      'percentageClass' => $percentageClass,
      'percentageIcon' => $percentageClass == 'success' ? 'up-arrow-alt' : 'down-arrow-alt',
      'progressPercentage' => $completedPercentage,
      'progressMessage' => __('dashboard.progress_completed_percentage', ['percentage' => $completedPercentage])
    ];

    $total = Payment::where('payable_type', Wallet::class)->sum('amount');
    $this_month = Payment::where('payable_type', Wallet::class)->whereMonth('created_at', now()->month)->sum('amount');
    $last_month = Payment::where('payable_type', Wallet::class)->whereMonth('created_at', now()->subMonth(1)->month)->sum('amount');
    $percentageChange = number_format(($this_month - $last_month) / max($last_month,1) * 100 , 0);
    $percentageClass = $percentageChange >= 0 ? 'success' : 'danger';
    $paid = Payment::where('payable_type', Wallet::class)->where('status', 'paid')->sum('amount');
    $paidPercentage = number_format(($total > 0 ? ($paid / $total) : 0) * 100, 0);

    $walletStats = [
      'total' => $total,
      'monthly' => $this_month,
      'percentageChange' => $percentageChange,
      'percentageClass' => $percentageClass,
      'percentageIcon' => $percentageClass == 'success' ? 'up-arrow-alt' : 'down-arrow-alt',
      'progressPercentage' => $paidPercentage,
      'progressMessage' => __('dashboard.progress_paid_percentage', ['percentage' => $paidPercentage])
    ];

    $total = Payment::where('payable_type', Invoice::class)->sum('amount');
    $this_month = Payment::where('payable_type', Invoice::class)->whereMonth('created_at', now()->month)->sum('amount');
    $last_month = Payment::where('payable_type', Invoice::class)->whereMonth('created_at', now()->subMonth(1)->month)->sum('amount');
    $percentageChange = number_format(($this_month - $last_month) / max($last_month,1) * 100 , 0);
    $percentageClass = $percentageChange >= 0 ? 'success' : 'danger';
    $paid = Payment::where('payable_type', Invoice::class)->where('status', 'paid')->sum('amount');
    $paidPercentage = number_format(($total > 0 ? ($paid / $total) : 0) * 100, 0);

    $invoiceStats = [
      'total' => $total,
      'monthly' => $this_month,
      'percentageChange' => $percentageChange,
      'percentageClass' => $percentageClass,
      'percentageIcon' => $percentageClass == 'success' ? 'up-arrow-alt' : 'down-arrow-alt',
      'progressPercentage' => $paidPercentage,
      'progressMessage' => __('dashboard.progress_paid_percentage', ['percentage' => $paidPercentage])
    ];

    return view('template.dashboards-analytics', compact(
      'driverStats',
      'renterStats',
      'tripStats',
      'shipmentStats',
      'walletStats',
      'invoiceStats'
    ));
  }
}
