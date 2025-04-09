@extends('layouts/contentNavbarLayout')

@section('title', __('dashboard.analytics_title'))

@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/apex-charts/apex-charts.css')}}">
@endsection

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/apex-charts/apexcharts.js')}}"></script>
@endsection

@section('page-script')
<script src="{{asset('assets/js/dashboards-analytics.js')}}"></script>
@endsection

@section('content')
<!-- Main Cards -->
<div class="row">
  <!-- Drivers Card -->
  <div class="col-md-6 col-lg-4 mb-4">
    <div class="card h-100">
      <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="card-title m-0 me-2">{{ __('dashboard.drivers') }}</h5>
        <a href="{{ url('driver/index') }}" class="btn btn-sm btn-blue">{{ __('dashboard.view_all') }}</a>
      </div>
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <div class="d-flex flex-column">
            <span class="fw-semibold d-block mb-1">{{ __('dashboard.total_drivers') }}</span>
            <h3 class="card-title mb-2">{{ $driverStats['total'] }}</h3>
          </div>
          <div class="avatar flex-shrink-0">
            <span class="avatar-initial rounded bg-label-blue">
              <i class="bx bx-bus"></i>
            </span>
          </div>
        </div>
        <div class="d-flex justify-content-between mb-2">
          <span>{{ __('dashboard.this_month') }}</span>
          <span class="fw-semibold">{{ $driverStats['monthly'] }}</span>
        </div>
        <div class="d-flex justify-content-between mb-4">
          <span class="text-muted">{{ __('dashboard.compared_last_month') }}</span>
          <span class="text-{{ $driverStats['percentageClass'] }} fw-semibold">
            <i class='bx bx-{{ $driverStats['percentageIcon'] }}'></i> {{ $driverStats['percentageChange'] }}%
          </span>
        </div>
        <div class="progress mb-2" style="height: 8px;">
          <div class="progress-bar bg-blue" role="progressbar" style="width: {{ $driverStats['progressPercentage'] }}%"
               aria-valuenow="{{ $driverStats['progressPercentage'] }}" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <small class="text-muted">{{ $driverStats['progressMessage'] }}</small>
      </div>
    </div>
  </div>

  <!-- Renters Card -->
  <div class="col-md-6 col-lg-4 mb-4">
    <div class="card h-100">
      <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="card-title m-0 me-2">{{ __('dashboard.renters') }}</h5>
        <a href="{{ url('renter/index') }}" class="btn btn-sm btn-red">{{ __('dashboard.view_all') }}</a>
      </div>
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <div class="d-flex flex-column">
            <span class="fw-semibold d-block mb-1">{{ __('dashboard.total_renters') }}</span>
            <h3 class="card-title mb-2">{{ $renterStats['total'] }}</h3>
          </div>
          <div class="avatar flex-shrink-0">
            <span class="avatar-initial rounded bg-label-red">
              <i class="bx bx-user"></i>
            </span>
          </div>
        </div>
        <div class="d-flex justify-content-between mb-2">
          <span>{{ __('dashboard.this_month') }}</span>
          <span class="fw-semibold">{{ $renterStats['monthly'] }}</span>
        </div>
        <div class="d-flex justify-content-between mb-4">
          <span class="text-muted">{{ __('dashboard.compared_last_month') }}</span>
          <span class="text-{{ $renterStats['percentageClass'] }} fw-semibold">
            <i class='bx bx-{{ $renterStats['percentageIcon'] }}'></i> {{ $renterStats['percentageChange'] }}%
          </span>
        </div>
        <div class="progress mb-2" style="height: 8px;">
          <div class="progress-bar bg-red" role="progressbar" style="width: {{ $renterStats['progressPercentage'] }}%"
               aria-valuenow="{{ $renterStats['progressPercentage'] }}" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <small class="text-muted">{{ $renterStats['progressMessage'] }}</small>
      </div>
    </div>
  </div>

  <!-- Trips Card -->
  <div class="col-md-6 col-lg-4 mb-4">
    <div class="card h-100">
      <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="card-title m-0 me-2">{{ __('dashboard.trips') }}</h5>
      </div>
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <div class="d-flex flex-column">
            <span class="fw-semibold d-block mb-1">{{ __('dashboard.total_trips') }}</span>
            <h3 class="card-title mb-2">{{ $tripStats['total'] }}</h3>
          </div>
          <div class="avatar flex-shrink-0">
            <span class="avatar-initial rounded bg-label-info">
              <i class="bx bx-trip"></i>
            </span>
          </div>
        </div>
        <div class="d-flex justify-content-between mb-2">
          <span>{{ __('dashboard.this_month') }}</span>
          <span class="fw-semibold">{{ $tripStats['monthly'] }}</span>
        </div>
        <div class="d-flex justify-content-between mb-4">
          <span class="text-muted">{{ __('dashboard.compared_last_month') }}</span>
          <span class="text-{{ $tripStats['percentageClass'] }} fw-semibold">
            <i class='bx bx-{{ $tripStats['percentageIcon'] }}'></i> {{ $tripStats['percentageChange'] }}%
          </span>
        </div>
        <div class="progress mb-2" style="height: 8px;">
          <div class="progress-bar bg-info" role="progressbar" style="width: {{ $tripStats['progressPercentage'] }}%"
               aria-valuenow="{{ $tripStats['progressPercentage'] }}" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <small class="text-muted">{{ $tripStats['progressMessage'] }}</small>
      </div>
    </div>
  </div>

  <!-- Shipments Card -->
  <div class="col-md-6 col-lg-4 mb-4">
    <div class="card h-100">
      <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="card-title m-0 me-2">{{ __('dashboard.shipments') }}</h5>
      </div>
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <div class="d-flex flex-column">
            <span class="fw-semibold d-block mb-1">{{ __('dashboard.total_shipments') }}</span>
            <h3 class="card-title mb-2">{{ $shipmentStats['total'] }}</h3>
          </div>
          <div class="avatar flex-shrink-0">
            <span class="avatar-initial rounded bg-label-orange">
              <i class="bx bx-package"></i>
            </span>
          </div>
        </div>
        <div class="d-flex justify-content-between mb-2">
          <span>{{ __('dashboard.this_month') }}</span>
          <span class="fw-semibold">{{ $shipmentStats['monthly'] }}</span>
        </div>
        <div class="d-flex justify-content-between mb-4">
          <span class="text-muted">{{ __('dashboard.compared_last_month') }}</span>
          <span class="text-{{ $shipmentStats['percentageClass'] }} fw-semibold">
            <i class='bx bx-{{ $shipmentStats['percentageIcon'] }}'></i> {{ $shipmentStats['percentageChange'] }}%
          </span>
        </div>
        <div class="progress mb-2" style="height: 8px;">
          <div class="progress-bar bg-orange" role="progressbar" style="width: {{ $shipmentStats['progressPercentage'] }}%"
               aria-valuenow="{{ $shipmentStats['progressPercentage'] }}" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <small class="text-muted">{{ $shipmentStats['progressMessage'] }}</small>
      </div>
    </div>
  </div>

  <!-- Wallet Payments Card -->
  <div class="col-md-6 col-lg-4 mb-4">
    <div class="card h-100">
      <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="card-title m-0 me-2">{{ __('dashboard.wallet_payments') }}</h5>
        <a href="{{ url('payment/wallet') }}" class="btn btn-sm btn-purple">{{ __('dashboard.view_all') }}</a>
      </div>
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <div class="d-flex flex-column">
            <span class="fw-semibold d-block mb-1">{{ __('dashboard.total_amount') }}</span>
            <h3 class="card-title mb-2">{{ $walletStats['total'] }}{{__('app.currencies.dzd')}}</h3>
          </div>
          <div class="avatar flex-shrink-0">
            <span class="avatar-initial rounded bg-label-purple">
              <i class="bx bx-wallet"></i>
            </span>
          </div>
        </div>
        <div class="d-flex justify-content-between mb-2">
          <span>{{ __('dashboard.this_month') }}</span>
          <span class="fw-semibold">{{ $walletStats['monthly'] }}{{__('app.currencies.dzd')}}</span>
        </div>
        <div class="d-flex justify-content-between mb-4">
          <span class="text-muted">{{ __('dashboard.compared_last_month') }}</span>
          <span class="text-{{ $walletStats['percentageClass'] }} fw-semibold">
            <i class='bx bx-{{ $walletStats['percentageIcon'] }}'></i> {{ $walletStats['percentageChange'] }}%
          </span>
        </div>
        <div class="progress mb-2" style="height: 8px;">
          <div class="progress-bar bg-purple" role="progressbar" style="width: {{ $walletStats['progressPercentage'] }}%"
               aria-valuenow="{{ $walletStats['progressPercentage'] }}" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <small class="text-muted">{{ $walletStats['progressMessage'] }}</small>
      </div>
    </div>
  </div>

  <!-- Invoice Payments Card -->
  <div class="col-md-6 col-lg-4 mb-4">
    <div class="card h-100">
      <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="card-title m-0 me-2">{{ __('dashboard.invoice_payments') }}</h5>
        <a href="{{ url('payment/invoice') }}" class="btn btn-sm btn-teal">{{ __('dashboard.view_all') }}</a>
      </div>
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <div class="d-flex flex-column">
            <span class="fw-semibold d-block mb-1">{{ __('dashboard.total_amount') }}</span>
            <h3 class="card-title mb-2">{{ $invoiceStats['total'] }}{{__('app.currencies.dzd')}}</h3>
          </div>
          <div class="avatar flex-shrink-0">
            <span class="avatar-initial rounded bg-label-teal">
              <i class="bx bx-receipt"></i>
            </span>
          </div>
        </div>
        <div class="d-flex justify-content-between mb-2">
          <span>{{ __('dashboard.this_month') }}</span>
          <span class="fw-semibold">{{ $invoiceStats['monthly'] }}{{__('app.currencies.dzd')}}</span>
        </div>
        <div class="d-flex justify-content-between mb-4">
          <span class="text-muted">{{ __('dashboard.compared_last_month') }}</span>
          <span class="text-{{ $invoiceStats['percentageClass'] }} fw-semibold">
            <i class='bx bx-{{ $invoiceStats['percentageIcon'] }}'></i> {{ $invoiceStats['percentageChange'] }}%
          </span>
        </div>
        <div class="progress mb-2" style="height: 8px;">
          <div class="progress-bar bg-teal" role="progressbar" style="width: {{ $invoiceStats['progressPercentage'] }}%"
               aria-valuenow="{{ $invoiceStats['progressPercentage'] }}" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <small class="text-muted">{{ $invoiceStats['progressMessage'] }}</small>
      </div>
    </div>
  </div>
</div>
@endsection
