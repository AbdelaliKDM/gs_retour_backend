@extends('layouts/contentNavbarLayout')

@section('title', __('payment.payment_information'))

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/apex-charts/apex-charts.css') }}">
@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
@endsection

@section('content')
    <h4 class="fw-bold py-3 mb-3 row justify-content-between">
        <div class="col-md-auto">
            <span class="text-muted fw-light">{{ __('payment.payment_information') }} /</span> #{{ $payment->id }}
        </div>
        @if ($payment->status == 'pending')
            <div class="col-md-auto">
                <button type="button" class="btn btn-teal" data-bs-toggle="modal" data-bs-target="#accept-modal"
                    data-id="{{ $payment->id }}">
                    <i class="bx bx-check me-1"></i> {{ __('payment.actions.accept') }}
                </button>

                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#reject-modal"
                    data-id="{{ $payment->id }}">
                    <i class="bx bx-x me-1"></i> {{ __('payment.actions.reject') }}
                </button>
            </div>
        @endif
    </h4>


    <div class="row">
        <!-- Payment Details -->
        <div class="col-xl-8 col-lg-7 col-md-7">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ __('payment.payment_information') }}</h5>
                    <span
                        class="badge bg-label-{{ $payment->status == 'paid' ? 'teal' : ($payment->status == 'pending' ? 'secondary' : 'danger') }} fs-5">
                        {{ __("payment.statuses.{$payment->status}") }}
                    </span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card bg-light mb-4">
                                <div class="card-body py-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="text-muted">{{ __('payment.labels.amount') }}</span>
                                        <span class="fs-3 fw-bold">{{ number_format($payment->amount) }}
                                            {{ __('app.currencies.dzd') }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="info-container">
                                        <div class="mb-3">
                                            <small class="text-muted d-block mb-2">{{ __('payment.labels.type') }}</small>
                                            <span
                                                class="badge bg-label-{{ $payment->type == 'wallet' ? 'warning' : 'info' }} fs-6">
                                                {{ __("payment.types.{$payment->type}") }}
                                            </span>
                                        </div>
                                        <div class="mb-3">
                                            <small
                                                class="text-muted d-block mb-2">{{ __('payment.labels.payment_method') }}</small>
                                            <span
                                                class="badge bg-label-{{ $payment->payment_method == 'cash'
                                                    ? 'teal'
                                                    : ($payment->payment_method == 'wallet'
                                                        ? 'warning'
                                                        : ($payment->payment_method == 'ccp'
                                                            ? 'blue'
                                                            : ($payment->payment_method == 'baridi'
                                                                ? 'info'
                                                                : 'secondary'))) }} fs-6">
                                                {{ $payment->payment_method_name ?? __("payment.payment_methods.{$payment->payment_method}") }}
                                            </span>
                                        </div>
                                        <div class="mb-3">
                                            <small
                                                class="text-muted d-block mb-2">{{ __('payment.labels.receipt') }}</small>
                                            @if ($payment->receipt)
                                                <a href="{{ $payment->receipt_url }}"
                                                    class="btn btn-outline-primary btn-sm" target="_blank">
                                                    <i class="bx bx-receipt me-1"></i>{{ __('payment.labels.receipt') }}
                                                </a>
                                            @else
                                                <button class="btn btn-outline-secondary btn-sm" disabled>
                                                    <i class="bx bx-receipt me-1"></i>{{ __('payment.labels.receipt') }}
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-container">
                                        <div class="mb-3">
                                            <small
                                                class="text-muted d-block mb-2">{{ __('payment.labels.created_at') }}</small>
                                            <h6>{{ $payment->created_at->format('d M Y H:i') }}</h6>
                                        </div>
                                        <div class="mb-3">
                                            <small
                                                class="text-muted d-block mb-2">{{ __('payment.labels.paid_at') }}</small>
                                            <h6>{{ $payment->paid_at ? $payment->paid_at->format('d M Y H:i') : '-' }}</h6>
                                        </div>
                                        <div class="mb-3">
                                            <small
                                                class="text-muted d-block mb-2">{{ __('payment.labels.account_number') }}</small>
                                            <h6>{{ $payment->account ?? '-' }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Payer Information -->
        <div class="col-xl-4 col-lg-5 col-md-5">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">{{ __('payment.payer_information') }}</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-start align-items-sm-center gap-4 mb-4">
                        <img src="{{ $payment->payable->user->image_url ?? 'https://placehold.co/100?text=No+Image' }}"
                            alt="user-avatar" class="d-block rounded" height="100" width="100" />
                        <div class="d-flex flex-column">
                            <h5 class="mb-1">{{ $payment->payable->user->name }}</h5>
                            <div class="mb-1">
                                <span
                                    class="badge bg-label-{{ $payment->payable->user->role == 'driver' ? 'info' : ($payment->payable->user->role == 'renter' ? 'warning' : 'secondary') }}">
                                    {{ __('user.roles.' . ($payment->payable->user->role ?? 'null')) }}
                                </span>
                            </div>
                            <small class="text-muted">{{ __('user.labels.id') }}:
                                #{{ $payment->payable->user->id }}</small>
                        </div>
                    </div>

                    <div class="info-container">
                        <div class="mb-3">
                            <small class="text-muted d-block">{{ __('payment.labels.email') }}</small>
                            <h6>{{ $payment->payable->user->email ?? '-' }}</h6>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted d-block">{{ __('payment.labels.phone') }}</small>
                            <h6>{{ $payment->payable->user->phone ?? '-' }}</h6>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payable Information (Wallet or Invoice) -->
            @if ($payment->type == 'wallet')
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">{{ __('payment.wallet_information') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="info-container">
                            <div class="mb-3">
                                <small class="text-muted d-block">{{ __('payment.labels.balance') }}</small>
                                <h6>{{ number_format($payment->payable->balance) }} {{ __('app.currencies.dzd') }}</h6>
                            </div>
                            <div class="mb-3">
                                <small class="text-muted d-block">{{ __('payment.labels.charges') }}</small>
                                <h6>{{ $payment->payable->charges ?? '-' }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            @elseif($payment->type == 'invoice')
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">{{ __('payment.invoice_information') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="info-container">
                            <div class="mb-3">
                                <small class="text-muted d-block">{{ __('payment.labels.total_amount') }}</small>
                                <h6>{{ number_format($payment->payable->total_amount) }} {{ __('app.currencies.dzd') }}
                                </h6>
                            </div>
                            <div class="mb-3">
                                <small class="text-muted d-block">{{ __('payment.labels.tax_amount') }}</small>
                                <h6>{{ number_format($payment->payable->tax_amount) }} {{ __('app.currencies.dzd') }}</h6>
                            </div>
                            <div class="mb-3">
                                <small class="text-muted d-block">{{ __('payment.labels.month') }}</small>
                                <h6>{{ $payment->payable->month_name }} {{ $payment->payable->year }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>


    </div>
@endsection

@section('page-script')
    <script>
        $(function() {
            // Handle accept/reject modals
            $('#accept-modal, #reject-modal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var id = button.data('id');
                $(this).find('input[name="id"]').val(id);
            });

            // Accept form submission
            $('#accept-submit').on('click', function() {
                var formdata = new FormData($("#accept-form")[0]);

                $("#accept-modal").modal("hide");

                $.ajax({
                    url: '{{ url('payment/update') }}',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST',
                    data: formdata,
                    processData: false,
                    contentType: false,
                    dataType: 'JSON',
                    success: function(response) {
                        if (response.status == 1) {
                            Swal.fire({
                                title: "{{ __('Success') }}",
                                text: "{{ __('success') }}",
                                icon: 'success',
                                confirmButtonText: 'Ok'
                            }).then((result) => {
                              window.location.href = "/payment/{{$payment->type}}";
                            });
                        } else {
                            Swal.fire(
                                "{{ __('Error') }}",
                                response.message,
                                'error'
                            );
                        }
                    },
                    error: function(data) {
                        var errors = data.responseJSON;
                        Swal.fire(
                            "{{ __('Error') }}",
                            errors.message,
                            'error'
                        );
                        // Render the errors with js ...
                    }
                });
            });

            // Reject form submission
            $('#reject-submit').on('click', function() {
                var formdata = new FormData($("#reject-form")[0]);

                $("#reject-modal").modal("hide");

                $.ajax({
                    url: '{{ url('payment/update') }}',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST',
                    data: formdata,
                    processData: false,
                    contentType: false,
                    dataType: 'JSON',
                    success: function(response) {
                        if (response.status == 1) {
                            Swal.fire({
                                title: "{{ __('Success') }}",
                                text: "{{ __('success') }}",
                                icon: 'success',
                                confirmButtonText: 'Ok'
                            }).then((result) => {
                              window.location.href = "/payment/{{$payment->type}}";
                            });
                        } else {
                            Swal.fire(
                                "{{ __('Error') }}",
                                response.message,
                                'error'
                            );
                        }
                    },
                    error: function(data) {
                        var errors = data.responseJSON;
                        Swal.fire(
                            "{{ __('Error') }}",
                            errors.message,
                            'error'
                        );
                        // Render the errors with js ...
                    }
                });
            });
        });
    </script>
@endsection

@include('content.payment.accept')
@include('content.payment.reject')
