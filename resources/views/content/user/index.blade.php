@extends('layouts/contentNavbarLayout')

@section('title', __("{$model}.title"))

@section('content')

    <h4 class="fw-bold py-3 mb-3 row justify-content-between">
        <div class="col-md-auto">
            <span class="text-muted fw-light">{{ __("{$model}.breadcrumb") }} /</span> {{ __("{$model}.browse") }}
        </div>
        <div class="col-md-auto">
            <button type="button" class="btn btn-primary" id="create">
                <span class="tf-icons bx bx-plus"></span>{{ __("{$model}.actions.create") }}
            </button>
        </div>
    </h4>

    <!-- Basic Bootstrap Table -->
    <div class="card">
        <div class="table-responsive text-nowrap">
            <div class="table-header row justify-content-between">
                <h5 class="col-md-auto">{{ __("{$model}.table.header") }}</h5>
            </div>
            <table class="table" id="laravel_datatable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ __("{$model}.table.name") }}</th>
                        <th>{{ __("{$model}.table.role") }}</th>
                        <th>{{ __("{$model}.table.email") }}</th>
                        <th>{{ __("{$model}.table.phone") }}</th>
                        <th>{{ __("{$model}.table.status") }}</th>
                        <th>{{ __("{$model}.table.created_at") }}</th>
                        <th>{{ __("{$model}.table.actions") }}</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    @include("content.{$model}.create")
    @include("content.{$model}.update")
    @include("content.{$model}.delete")
    @include("content.{$model}.renter-info")
    @include("content.{$model}.driver-info")
@endsection


@section('page-script')
    <script>
        $(document).ready(function() {
            load_data();

            function load_data() {
                //$.fn.dataTable.moment( 'YYYY-M-D' );
                var table = $('#laravel_datatable').DataTable({
                    language: {!! file_get_contents(base_path('lang/' . session('locale', 'en') . '/datatable.json')) !!},
                    responsive: true,
                    processing: true,
                    serverSide: true,
                    pageLength: 10,

                    ajax: {
                        url: '{{ url("{$model}/list") }}',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'POST',
                    },

                    columns: [

                        {
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex'
                        },

                        {
                            data: 'name',
                            name: 'name'
                        },

                        {
                            data: 'role',
                            name: 'role',
                            render: function(data) {
                                if (data == null) {
                                    return '<span class="badge bg-label-secondary">{{ __('user.roles.null') }}</span>';
                                }
                                if (data == 'renter') {
                                    return '<span class="badge bg-label-warning">{{ __('user.roles.renter') }}</span>';
                                }
                                if (data == 'driver') {
                                    return '<span class="badge bg-label-info">{{ __('user.roles.driver') }}</span>';
                                }

                            },
                        },

                        {
                            data: 'email',
                            name: 'email'
                        },

                        {
                            data: 'phone',
                            name: 'phone'
                        },

                        {
                            data: 'status',
                            name: 'status',
                            render: function(data) {
                                if (data == 'active') {
                                    return '<span class="badge bg-label-success">{{ __('user.statuses.active') }}</span>';
                                }
                                if (data == 'inactive') {
                                    return '<span class="badge bg-label-warning">{{ __('user.statuses.inactive') }}</span>';
                                }
                                if (data == 'suspended') {
                                    return '<span class="badge bg-label-danger">{{ __('user.statuses.suspended') }}</span>';
                                }

                            },
                        },

                        {
                            data: 'created_at',
                            name: 'created_at'
                        },

                        {
                            data: 'action',
                            name: 'action',
                            searchable: false
                        }

                    ]
                });
            }

            $('#create').on('click', function() {
                $('#create-form')[0].reset();
                $('#create-modal').modal('show');
            });

            $('#create-submit').on('click', function() {

                $("#create-modal").modal("hide");

                var formdata = new FormData($("#create-form")[0]);

                $.ajax({
                    url: '{{ url("{$model}/create") }}',
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
                                $('#laravel_datatable').DataTable().ajax
                                    .reload();
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

            $(document.body).on('click', '.update', function() {

                var id = $(this).data('id');
                var modal = $("#update-modal");

                $.ajax({
                    url: '{{ url("{$model}/get") }}',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST',
                    data: {
                        id: id
                    },
                    dataType: 'JSON',
                    success: function(response) {
                        if (response.status) {
                            modal.find('input[name="id"]').val(response.data.id);
                            modal.find('input[name="name"]').val(response.data.name);
                            modal.find('input[name="email"]').val(response.data.email);
                            modal.find('input[name="phone"]').val(response.data.phone);
                            modal.modal("show");
                        }
                    }
                });
            });


            $('#update-submit').on('click', function() {

                $("#update-modal").modal("hide");

                var formdata = new FormData($("#update-form")[0]);

                $.ajax({
                    url: '{{ url("{$model}/update") }}',
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
                                $('#laravel_datatable').DataTable().ajax
                                    .reload();
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

            $(document.body).on('click', '.delete', function() {

                var id = $(this).data('id');
                var modal = $('#delete-modal');

                modal.find('input[name="id"]').val(id);

                modal.find('.related-items-list').empty();

                $.ajax({
                    url: '{{ url("{$model}/delete") }}',
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


            $('#delete-submit').on('click', function() {

                var modal = $("#delete-modal");

                if (modal.find('input[name="confirm_delete"]').prop('checked')) {

                    modal.modal("hide");

                    var formdata = new FormData($("#delete-form")[0]);

                    $.ajax({
                        url: '{{ url("{$model}/delete") }}',
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
                                    $('#laravel_datatable').DataTable().ajax
                                        .reload();
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
                }


            });


            $(document.body).on('click', '.info', function() {
                var id = $(this).data('id');

                $.ajax({
                    url: '{{ url("{$model}/get") }}',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST',
                    data: {
                        id: id
                    },
                    dataType: 'JSON',
                    success: function(response) {
                        if (response.status) {
                            var data = response.data;
                            var $modal = data.role === 'driver' ? $('#driver-info-modal') : $(
                                '#renter-info-modal');

                            // Populate user information
                            $modal.find('.user-name').text(data.name || '-');
                            $modal.find('.user-phone').text(data.phone || '-');
                            $modal.find('.user-email').text(data.email || '-');

                            if (data.image) {
                                $modal.find('.user-image').attr('src', data.image);
                            } else {
                                $modal.find('.user-image').attr('src',
                                    'https://placehold.co/100?text=User');
                            }

                            // Populate user documents
                            setDocumentLink($modal.find('.id-card-link'), data.id_card);
                            setDocumentLink($modal.find('.id-card-selfie-link'), data
                                .id_card_selfie);

                            // Handle truck information (if exists)
                            if (data.truck) {
                                $modal.find('.truck-section').show(); // Show truck section

                                // Populate truck fields
                                $modal.find('.truck-type').text(data.truck.truck_type || '-');
                                $modal.find('.serial-number').text(data.truck.serial_number ||
                                    '-');

                                // Handle truck documents
                                setDocumentLink($modal.find('.gray-card-link'), data.truck
                                    .gray_card);
                                setDocumentLink($modal.find('.driving-license-link'), data.truck
                                    .driving_license);
                                setDocumentLink($modal.find('.insurance-certificate-link'), data
                                    .truck.insurance_certificate);
                                setDocumentLink($modal.find('.inspection-certificate-link'),
                                    data.truck.inspection_certificate);

                                $modal.find('.insurance-expiry-date').text(data.truck
                                    .insurance_expiry_date || '-');
                                $modal.find('.next-inspection-date').text(data.truck
                                    .next_inspection_date || '-');

                                // Handle agency affiliation

                                $modal.find('.affiliated-with-agency').text(data.truck
                                    .affiliated_with_agency ? 'Yes' : 'No');


                                setDocumentLink($modal.find('.agency-document-link'),
                                    data.truck.agency_document);


                            } else {
                                // Hide truck section if no truck data exists
                                $modal.find('.truck-section').remove();
                            }

                            $modal.modal('show');
                        }
                    }
                });
            });

            // Helper function to set document links
            function setDocumentLink($element, documentUrl) {
                if (documentUrl) {
                    $element.removeClass('disabled').attr('href', documentUrl);
                } else {
                    $element.addClass('disabled').attr('href', '#');
                }
            }

            $(document.body).on('click', '.suspend', function() {

                var id = $(this).attr('table_id');

                Swal.fire({
                    title: "{{ __('Warning') }}",
                    text: "{{ __('Are you sure?') }}",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: "{{ __('Yes') }}",
                    cancelButtonText: "{{ __('No') }}"
                }).then((result) => {
                    if (result.isConfirmed) {

                        $.ajax({
                            url: '{{ url("{$model}/update") }}',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            type: 'POST',
                            data: {
                                id: id,
                                status: 'suspended'
                            },
                            dataType: 'JSON',
                            success: function(response) {
                                if (response.status == 1) {

                                    Swal.fire(
                                        "{{ __('Success') }}",
                                        "{{ __('success') }}",
                                        'success'
                                    ).then((result) => {
                                        $('#laravel_datatable').DataTable().ajax
                                            .reload();
                                    });
                                }
                            }
                        });


                    }
                })
            });

            $(document.body).on('click', '.activate', function() {

                var id = $(this).attr('table_id');

                Swal.fire({
                    title: "{{ __('Warning') }}",
                    text: "{{ __('Are you sure?') }}",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: "{{ __('Yes') }}",
                    cancelButtonText: "{{ __('No') }}"
                }).then((result) => {
                    if (result.isConfirmed) {

                        $.ajax({
                            url: '{{ url("{$model}/update") }}',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            type: 'POST',
                            data: {
                                id: id,
                                status: 'active'
                            },
                            dataType: 'JSON',
                            success: function(response) {
                                if (response.status == 1) {

                                    Swal.fire(
                                        "{{ __('Success') }}",
                                        "{{ __('success') }}",
                                        'success'
                                    ).then((result) => {
                                        $('#laravel_datatable').DataTable().ajax
                                            .reload();
                                    });
                                }
                            }
                        });


                    }
                })
            });

        });
    </script>
@endsection
