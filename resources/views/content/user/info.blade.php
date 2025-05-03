@extends('layouts/contentNavbarLayout')

@section('title', __('user.user_information'))

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/apex-charts/apex-charts.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <style>
        .square-image-container {
            position: relative;
            width: 100%;
            padding-top: 100%;
            overflow: hidden;
            display: block;
        }

        .square-image {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        #swiper-truck-images .swiper-slide {
            height: auto;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
@endsection

@section('content')
    <h4 class="fw-bold py-3 mb-4 row justify-content-between">
        <div class="col-md-auto">
            <span class="text-muted fw-light">{{ __('user.user_information') }} /</span> {{ $user->name }}
        </div>

        <div class="col-md-auto">
            {{-- @if ($user->status == 'active')
                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#reject-modal"
                    data-id="{{ $user->id }}">
                    <i class="bx bx-x me-1"></i> {{ __('user.actions.reject') }}
                </button>
            @else
                <button type="button" class="btn btn-teal" data-bs-toggle="modal" data-bs-target="#accept-modal"
                    data-id="{{ $user->id }}">
                    <i class="bx bx-check me-1"></i> {{ __('user.actions.accept') }}
                </button>
            @endif --}}

            <button type="button" class="btn btn-danger delete" data-id="{{ $user->id }}">
                <i class="bx bx-trash me-1"></i> {{ __('user.actions.delete') }}
            </button>
        </div>
    </h4>

    <div class="row">
        <!-- User Profile Details -->
        <div class="col-xl-4 col-lg-5 col-md-5">
            @if ($user->profile_status == 'inactive')
            <div class="alert alert-warning d-flex align-items-center flex-wrap gap-1" role="alert">
                <span class="alert-icon rounded-circle"><i class="icon-base bx bx-error icon-sm"></i></span>
                {{ __('user.profile_message') }}
                <div class="ms-auto">
                    
                        <button type="button" class="btn btn-sm btn-icon btn-label-danger" data-bs-toggle="modal" data-bs-target="#reject-modal" data-id="{{ $user->id }}" data-type="profile" title="{{ __('user.actions.reject') }}">
                            <i class="bx bx-x"></i>
                        </button>
                    
                        <button type="button" class="btn btn-sm btn-icon btn-label-teal" data-bs-toggle="modal" data-bs-target="#accept-modal" data-id="{{ $user->id }}" data-type="profile" title="{{ __('user.actions.accept') }}">
                            <i class="bx bx-check"></i>
                        </button>
                    
                </div>
            </div>
            @endif
            <div class="card mb-4">
                <div class="card-body">
                    <div class="d-flex align-items-start align-items-sm-center gap-4 mb-4">
                        <img src="{{ $user->image_url ?? 'https://placehold.co/100?text=No+Image' }}" alt="user-avatar"
                            class="d-block rounded" height="100" width="100" id="uploadedAvatar" />
                        <div class="d-flex flex-column">
                            <h5 class="mb-1">{{ $user->name }}</h5>
                            <div class="mb-1">
                                <span
                                    class="badge bg-label-{{ $user->role == 'driver' ? 'info' : ($user->role == 'renter' ? 'warning' : 'secondary') }}">
                                    {{ __('user.roles.' . ($user->role ?? 'null')) }}
                                </span>
                                <span
                                    class="badge bg-label-{{ $user->status == 'active' ? 'teal' : ($user->status == 'inactive' ? 'warning' : 'danger') }}">
                                    {{ __('user.statuses.' . $user->status) }}
                                </span>
                            </div>
                            <small class="text-muted">{{ __('user.labels.id') }}: #{{ $user->id }}</small>
                        </div>
                    </div>

                    <div class="info-container">
                        <div class="mb-3">
                            <small class="text-muted d-block">{{ __('user.labels.email') }}</small>
                            <h6>{{ $user->email ?? '-' }}</h6>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted d-block">{{ __('user.labels.phone') }}</small>
                            <h6>{{ $user->phone ?? '-' }}</h6>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted d-block">{{ __('user.labels.created_at') }}</small>
                            <h6>{{ $user->created_at->format('d M Y') }}</h6>
                        </div>

                        <!-- User Documents -->
                        <div class="mb-1">
                            <small class="text-muted d-block mb-2">{{ __('user.documents') }}</small>
                            @if ($user->id_card)
                                <a href="{{ url($user->id_card) }}" class="btn btn-outline-primary btn-sm" target="_blank">
                                    <i class="bx bx-id-card me-1"></i>{{ __('user.labels.id_card') }}
                                </a>
                            @else
                                <button class="btn btn-outline-secondary btn-sm" disabled>
                                    <i class="bx bx-id-card me-1"></i>{{ __('user.labels.id_card') }}
                                </button>
                            @endif

                            @if ($user->id_card_selfie)
                                <a href="{{ url($user->id_card_selfie) }}" class="btn btn-outline-primary btn-sm"
                                    target="_blank">
                                    <i class="bx bx-camera me-1"></i>{{ __('user.labels.id_card_selfie') }}
                                </a>
                            @else
                                <button class="btn btn-outline-secondary btn-sm" disabled>
                                    <i class="bx bx-camera me-1"></i>{{ __('user.labels.id_card_selfie') }}
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Truck Information (for drivers only) -->
        @if ($user->role == 'driver' && $user->truck)
            <div class="col-xl-8 col-lg-7 col-md-7">
                @if ($user->truck_status == 'inactive')
                <div class="alert alert-warning d-flex align-items-center flex-wrap gap-1" role="alert">
                    <span class="alert-icon rounded-circle"><i class="icon-base bx bx-error icon-sm"></i></span>
                    {{ __('user.truck_message') }}
                    <div class="ms-auto">
                        
                            <button type="button" class="btn btn-sm btn-icon btn-label-danger" data-bs-toggle="modal" data-bs-target="#reject-modal" data-id="{{ $user->id }}" data-type="truck" title="{{ __('user.actions.reject') }}">
                                <i class="bx bx-x"></i>
                            </button>
                        
                            <button type="button" class="btn btn-sm btn-icon btn-label-teal" data-bs-toggle="modal" data-bs-target="#accept-modal" data-id="{{ $user->id }}" data-type="truck" title="{{ __('user.actions.accept') }}">
                                <i class="bx bx-check"></i>
                            </button>
                        
                    </div>
                </div>
                @endif
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between">
                        <h5 class="mb-0">{{ __('user.truck.truck_information') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Truck Data Column -->
                            <div class="col-md-4">
                                <div class="info-container">
                                    <div class="mb-3">
                                        <small class="text-muted d-block">{{ __('user.truck.serial_number') }}</small>
                                        <h6>{{ $user->truck->serial_number ?? '-' }}</h6>
                                    </div>

                                    <div class="mb-3">
                                        <small class="text-muted d-block">{{ __('user.truck.truck_type') }}</small>
                                        <h6>{{ $user->truck->truckType->name ?? '-' }}</h6>
                                    </div>

                                    <div class="mb-3">
                                        <small
                                            class="text-muted d-block">{{ __('user.truck.insurance_expiry_date') }}</small>
                                        <h6>{{ $user->truck->insurance_expiry_date ?? '-' }}</h6>
                                    </div>

                                    <div class="mb-3">
                                        <small
                                            class="text-muted d-block">{{ __('user.truck.next_inspection_date') }}</small>
                                        <h6>{{ $user->truck->next_inspection_date ?? '-' }}</h6>
                                    </div>

                                    <div class="mb-3">
                                        <small
                                            class="text-muted d-block">{{ __('user.truck.affiliated_with_agency') }}</small>
                                        <span
                                            class="badge bg-label-{{ $user->truck->affiliated_with_agency ? 'teal' : 'danger' }}">
                                            {{ $user->truck->affiliated_with_agency ? __('app.yes') : __('app.no') }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Documents and Images Column -->
                            <div class="col-md-8">
                                <!-- Truck Documents -->
                                <div class="mb-4">
                                    <small class="text-muted d-block mb-2">{{ __('user.truck.documents') }}</small>
                                    <div class="d-flex flex-wrap gap-2">
                                        @if ($user->truck->gray_card_url)
                                            <a href="{{ $user->truck->gray_card_url }}"
                                                class="btn btn-outline-primary btn-sm" target="_blank">
                                                <i class="bx bx-file me-1"></i>{{ __('user.truck.gray_card') }}
                                            </a>
                                        @else
                                            <button class="btn btn-outline-secondary btn-sm" disabled>
                                                <i class="bx bx-file me-1"></i>{{ __('user.truck.gray_card') }}
                                            </button>
                                        @endif

                                        @if ($user->truck->driving_license_url)
                                            <a href="{{ $user->truck->driving_license_url }}"
                                                class="btn btn-outline-primary btn-sm" target="_blank">
                                                <i class="bx bx-id-card me-1"></i>{{ __('user.truck.driving_license') }}
                                            </a>
                                        @else
                                            <button class="btn btn-outline-secondary btn-sm" disabled>
                                                <i class="bx bx-id-card me-1"></i>{{ __('user.truck.driving_license') }}
                                            </button>
                                        @endif

                                        @if ($user->truck->insurance_certificate_url)
                                            <a href="{{ $user->truck->insurance_certificate_url }}"
                                                class="btn btn-outline-primary btn-sm" target="_blank">
                                                <i
                                                    class="bx bx-shield me-1"></i>{{ __('user.truck.insurance_certificate') }}
                                            </a>
                                        @else
                                            <button class="btn btn-outline-secondary btn-sm" disabled>
                                                <i
                                                    class="bx bx-shield me-1"></i>{{ __('user.truck.insurance_certificate') }}
                                            </button>
                                        @endif

                                        @if ($user->truck->inspection_certificate_url)
                                            <a href="{{ $user->truck->inspection_certificate_url }}"
                                                class="btn btn-outline-primary btn-sm" target="_blank">
                                                <i
                                                    class="bx bx-check-shield me-1"></i>{{ __('user.truck.inspection_certificate') }}
                                            </a>
                                        @else
                                            <button class="btn btn-outline-secondary btn-sm" disabled>
                                                <i
                                                    class="bx bx-scan me-1"></i>{{ __('user.truck.inspection_certificate') }}
                                            </button>
                                        @endif

                                        @if ($user->truck->affiliated_with_agency && $user->truck->agency_document_url)
                                            <a href="{{ $user->truck->agency_document_url }}"
                                                class="btn btn-outline-primary btn-sm" target="_blank">
                                                <i class="bx bx-building me-1"></i>{{ __('user.truck.agency_document') }}
                                            </a>
                                        @elseif ($user->truck->affiliated_with_agency)
                                            <button class="btn btn-outline-secondary btn-sm" disabled>
                                                <i class="bx bx-building me-1"></i>{{ __('user.truck.agency_document') }}
                                            </button>
                                        @endif
                                    </div>
                                </div>

                                <!-- Truck Images Gallery -->
                                @if ($user->truck->truckImages && $user->truck->truckImages->count() > 0)
                                    <div>
                                        <small class="text-muted d-block mb-2">{{ __('user.truck.images') }}</small>
                                        <div class="swiper" id="swiper-truck-images">
                                            <div class="swiper-wrapper">
                                                @foreach ($user->truck->truckImages as $image)
                                                    <div class="swiper-slide">
                                                        <a href="{{ $image->url }}" target="_blank"
                                                            class="d-block square-image-container">
                                                            <img src="{{ $image->url }}" alt="Truck Image"
                                                                class="img-fluid rounded square-image">
                                                        </a>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="swiper-pagination"></div>
                                            <div class="swiper-button-next"></div>
                                            <div class="swiper-button-prev"></div>
                                        </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Wallet Information (for drivers only) -->
        @if ($user->role == 'driver' && $user->wallet)
            <div class="col-xl-6 col-lg-6 col-md-12">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">{{ __('payment.wallet.wallet_information') }}</h5>
                        <h5>
                            <span class="badge bg-label-primary">
                                {{ __('payment.wallet.balance') }}: {{ number_format($user->wallet->balance) }}
                                {{ __('app.currencies.dzd') }}
                            </span>
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>{{ __('payment.table.id') }}</th>
                                        <th>{{ __('payment.table.amount') }}</th>
                                        <th>{{ __('payment.table.status') }}</th>
                                        <th>{{ __('payment.table.created_at') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($payments as $payment)
                                        <tr>
                                            <td>#{{ $payment->id }}</td>
                                            <td>{{ number_format($payment->amount) }} {{ __('app.currencies.dzd') }}</td>
                                            <td>
                                                <span
                                                    class="badge bg-label-{{ $payment->status == 'paid' ? 'teal' : ($payment->status == 'pending' ? 'warning' : 'danger') }}">
                                                    {{ __("payment.statuses.{$payment->status}") }}
                                                </span>
                                            </td>
                                            <td>{{ $payment->created_at->format('d M Y') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">{{ __('payment.wallet.no_payments') }}
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-center mt-3">
                            {{ $payments->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Invoice Information (for drivers only) -->
            @if ($user->role == 'driver' && $user->invoices->count())
                <div class="col-xl-6 col-lg-6 col-md-12">
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">{{ __('payment.invoice.invoice_information') }}</h5>
                            <h5>
                                <span class="badge bg-label-danger">
                                    {{ __('payment.invoice.total_due') }}:
                                    {{ number_format($user->invoices->where('status', 'unpaid')->sum('tax_amount')) }}
                                    {{ __('app.currencies.dzd') }}
                                </span>
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>{{ __('payment.table.id') }}</th>
                                            <th>{{ __('payment.table.month') }}</th>
                                            <th>{{ __('payment.table.amount') }}</th>
                                            <th>{{ __('payment.table.status') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($invoices as $invoice)
                                            <tr>
                                                <td>#{{ $invoice->id }}</td>
                                                <td>{{ $invoice->month_name }} {{ $invoice->year }}</td>
                                                <td>{{ number_format($invoice->tax_amount) }}
                                                    {{ __('app.currencies.dzd') }}</td>
                                                <td>
                                                    <span
                                                        class="badge bg-label-{{ $invoice->status == 'paid'
                                                            ? 'teal'
                                                            : ($invoice->status == 'unpaid'
                                                                ? 'warning'
                                                                : ($invoice->status == 'unpayable'
                                                                    ? 'secondary'
                                                                    : 'danger')) }}">
                                                        {{ __("payment.statuses.{$invoice->status}") }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center">
                                                    {{ __('payment.invoice.no_invoices') }}</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex justify-content-center mt-3">
                                {{ $invoices->links('pagination::bootstrap-4') }}
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endif

    </div>

    @include('content.user.accept')
    @include('content.user.reject')
    @include('content.user.delete')
@endsection
@section('page-script')
    <script>
        $(function() {
            // Initialize Swiper for truck images gallery
            if (document.getElementById('swiper-truck-images')) {
                new Swiper('#swiper-truck-images', {
                    slidesPerView: 'auto',
                    spaceBetween: 10,
                    pagination: {
                        el: '.swiper-pagination',
                        clickable: true
                    },
                    navigation: {
                        nextEl: '.swiper-button-next',
                        prevEl: '.swiper-button-prev'
                    },
                    breakpoints: {
                        // When window width is >= 576px
                        576: {
                            slidesPerView: 2
                        },
                        // When window width is >= 768px
                        768: {
                            slidesPerView: 3
                        },
                        // When window width is >= 992px
                        992: {
                            slidesPerView: 3
                        }
                    }
                });
            }

            // Handle accept/reject modals
            $('#accept-modal, #reject-modal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var id = button.data('id');
                var type = button.data('type');
                $(this).find('input[name="id"]').val(id);
                $(this).find('input[name="types[]"]').val(type);
            });

            // Delete button click handler
            $(document.body).on('click', '.delete', function() {
                var id = $(this).data('id');
                var modal = $('#delete-modal');

                modal.find('input[name="id"]').val(id);
                modal.find('.related-items-list').empty();

                $.ajax({
                    url: '{{ url("user/delete") }}',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST',
                    data: {
                        id: id
                    },
                    dataType: 'JSON',
                    success: function(response) {
                        var $relatedList = modal.find('.related-items-list');
                        $relatedList.empty();

                        // Hide container if no related items
                        if (Object.keys(response.data).length === 0) {
                            modal.find('.related-items-container').hide();
                        } else {
                            modal.find('.related-items-container').show();

                            // Add each related item to the list
                            $.each(response.data, function(key, count) {
                                $relatedList.append(
                                    '<li class="list-group-item d-flex justify-content-between align-items-center">' +
                                    key +
                                    '<span class="badge bg-danger rounded-pill">' +
                                    count + '</span>' +
                                    '</li>'
                                );
                            });
                        }

                        modal.modal('show');
                    }
                });
            });

            // Delete form submission
            $('#delete-submit').on('click', function() {
                var modal = $("#delete-modal");

                if (modal.find('input[name="confirmed"]').prop('checked')) {
                    modal.modal("hide");

                    var formdata = new FormData($("#delete-form")[0]);

                    $.ajax({
                        url: '{{ url("user/delete") }}',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'POST',
                        data: formdata,
                        dataType: 'JSON',
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            if (response.status == 1) {
                                Swal.fire({
                                    title: "{{ __('Success') }}",
                                    text: "{{ __('success') }}",
                                    icon: 'success',
                                    confirmButtonText: 'Ok'
                                }).then((result) => {
                                    window.location.href = '{{ url("{$user->role()}/index") }}';
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
                        }
                    });
                }
            });

            // Accept form submission
            $('#accept-submit').on('click', function() {
                // Existing code remains unchanged
                var formdata = new FormData($("#accept-form")[0]);

                $("#accept-modal").modal("hide");

                $.ajax({
                    url: '{{ url('user/update') }}',
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
                                window.location.reload();
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
                    }
                });
            });

            // Reject form submission
            $('#reject-submit').on('click', function() {
                var formdata = new FormData($("#reject-form")[0]);

                $("#reject-modal").modal("hide");

                $.ajax({
                    url: '{{ url('user/update') }}',
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
                                window.location.reload();
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
                    }
                });
            });
        });
    </script>
@endsection
