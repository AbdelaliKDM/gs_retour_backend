@extends('layouts/contentNavbarLayout')

@section('title', __('trip.trip_information'))

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
            <span class="text-muted fw-light">{{ __('trip.breadcrumb') }} /</span> {{ __('trip.trip_information') }}
            #{{ $trip->id }}
        </div>

        <div class="col-md-auto">
            <button type="button" class="btn btn-danger delete" data-id="{{ $trip->id }}">
                <i class="bx bx-trash me-1"></i> {{ __('trip.actions.delete') }}
            </button>
        </div>
    </h4>

    <div class="row">
        <!-- Trip Information -->
        <div class="col-xl-8 col-lg-8 col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">{{ __('trip.trip_details') }}</h5>
                </div>
                <div class="card-body">
                    <div class="info-container">
                        <div class="row">
                            <!-- Trip Information -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <small class="text-muted d-block">{{ __('trip.table.status') }}</small>
                                    @php
                                        $statusClass =
                                            [
                                                'pending' => 'secondary',
                                                'ongoing' => 'info',
                                                'paused' => 'warning',
                                                'canceled' => 'danger',
                                                'completed' => 'teal',
                                            ][$trip->current_status] ?? 'secondary';
                                    @endphp
                                    <span class="badge bg-label-{{ $statusClass }}">
                                        {{ __("trip.statuses.{$trip->current_status}") }}
                                    </span>
                                </div>
                                <div class="mb-3">
                                    <small class="text-muted d-block">{{ __('trip.table.route') }}</small>
                                    <h6>{{ $trip->starting_wilaya_name }} {{ session('locale') == 'ar' ? ' ← ' : ' → ' }}
                                        {{ $trip->arrival_wilaya_name }}</h6>
                                </div>
                                <div class="mb-3">
                                    <small class="text-muted d-block">{{ __('trip.table.distance') }}</small>
                                    <h6>{{ $trip->distance }} {{ __('app.km') }}</h6>
                                </div>

                                <div class="mb-3">
                                    <small class="text-muted d-block">{{ __('trip.table.created_at') }}</small>
                                    <h6>{{ $trip->created_at->format('Y-m-d') }}</h6>
                                </div>

                            </div>
                            <div class="col-md-6">

                                <div class="mb-2">
                                    <small class="text-muted d-block">{{ __('trip.truck_type') }}</small>
                                    <h6>{{ $trip->truck_type_name }}</h6>
                                </div>

                                <div class="mb-3">
                                    <small class="text-muted d-block">{{ __('trip.table.starts_at') }}</small>
                                    <h6>{{ $trip->starts_at ? $trip->starts_at->format('Y-m-d') : '-' }}</h6>
                                </div>

                                <div class="mb-3">
                                    <small class="text-muted d-block">{{ __('trip.total_price') }}</small>
                                    <h6>{{ $trip->total_price }} {{ __('app.currencies.dzd') }}</h6>
                                </div>

                                <div class="mb-2">
                                    <small class="text-muted d-block">{{ __('trip.shipment_count') }}</small>
                                    <h6>{{ $trip->shipments_count }}</h6>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Driver and Truck Information -->
        <div class="col-xl-4 col-lg-4 col-md-4">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ __('trip.driver_information') }}</h5>

                    <a class="btn btn-icon btn-outline-primary" href="{{ url('user/' . $trip->friver_id . '/info') }}">
                        <span class="icon-base bx bx-user icon-md"></span>
                    </a>
                </div>
                <div class="card-body">
                    <!-- Driver Information -->
                    <div class="d-flex align-items-start align-items-sm-center gap-4 mb-4">
                        <img src="{{ $trip->driver->image_url ?? 'https://placehold.co/100?text=No+Image' }}"
                            alt="driver-avatar" class="d-block rounded" height="100" width="100" />
                        <div class="d-flex flex-column">
                            <h5 class="mb-1">{{ $trip->driver->name }}</h5>
                            <div class="mb-1">
                                <span class="badge bg-label-info">
                                    {{ __('user.roles.driver') }}
                                </span>
                                <span
                                    class="badge bg-label-{{ $trip->driver->status == 'active' ? 'teal' : ($trip->driver->status == 'inactive' ? 'warning' : 'danger') }}">
                                    {{ __('user.statuses.' . $trip->driver->status) }}
                                </span>
                            </div>
                            <small class="text-muted">{{ __('user.labels.id') }}: #{{ $trip->driver->id }}</small>
                        </div>
                    </div>

                    <div class="info-container">
                        <div class="mb-3">
                            <small class="text-muted d-block">{{ __('user.labels.email') }}</small>
                            <h6>{{ $trip->driver->email ?? '-' }}</h6>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted d-block">{{ __('user.labels.phone') }}</small>
                            <h6>{{ $trip->driver->phone ?? '-' }}</h6>
                        </div>

                        {{-- <div class="mb-3">
                            <a href="{{ url('user/' . $trip->driver->id . '/info') }}" class="btn btn-primary btn-sm">
                                <i class="bx bx-user me-1"></i> {{ __('trip.view_driver_profile') }}
                            </a>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Shipments Section -->
    @if ($trip->shipments && $trip->shipments->count() > 0)
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">{{ __('shipment.shipments') }}</h5>
                    </div>
                    <div class="table-responsive text-nowrap">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>{{ __('shipment.id') }}</th>
                                    <th>{{ __('shipment.renter') }}</th>
                                    <th>{{ __('shipment.type') }}</th>
                                    <th>{{ __('shipment.route') }}</th>
                                    <th>{{ __('shipment.distance') }}</th>
                                    <th>{{ __('shipment.price') }}</th>
                                    <th>{{ __('shipment.status') }}</th>
                                    {{-- <th>{{ __('shipment.actions') }}</th> --}}
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                                @foreach ($trip->shipments as $shipment)
                                    <tr>
                                        <td>#{{ $shipment->id }}</td>
                                        <td>
                                            <a href="{{ url('user/' . $shipment->renter->id . '/info') }}">
                                                {{ $shipment->renter->name }}
                                            </a>
                                        </td>
                                        <td>{{ $shipment->shipment_type_name }}</td>
                                        <td>{{ $shipment->starting_wilaya_name }}
                                            {{ session('locale') == 'ar' ? ' ← ' : ' → ' }}
                                            {{ $shipment->arrival_wilaya_name }}</td>
                                        <td>{{ $shipment->distance }} {{ __('app.km') }}</td>
                                        <td>{{ $shipment->price }} {{ __('app.currencies.dzd') }}</td>
                                        <td>
                                            @php
                                                $statusClass =
                                                    [
                                                        'pending' => 'secondary',
                                                        'shipped' => 'info',
                                                        'delivered' => 'teal',
                                                    ][$shipment->current_status] ?? 'secondary';
                                            @endphp
                                            <span class="badge bg-label-{{ $statusClass }}">
                                                {{ __("shipment.statuses.{$shipment->current_status}") }}
                                            </span>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @include('content.trip.delete')
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

            // Delete button click handler
            $(document.body).on('click', '.delete', function() {
                var id = $(this).data('id');
                var modal = $('#delete-modal');

                modal.find('input[name="id"]').val(id);
                modal.find('.related-items-list').empty();

                $.ajax({
                    url: '{{ url('trip/delete') }}',
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
                        url: '{{ url('trip/delete') }}',
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
                                    window.location.href =
                                        '{{ url('trip/' . $trip->current_status) }}';
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
        });
    </script>
@endsection
