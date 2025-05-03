@extends('layouts/contentNavbarLayout')

@section('title', __("user.title.{$type}"))

@section('vendor-style')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta3/css/bootstrap-select.css" integrity="sha512-JWw0M82pi7GIUtAZX0w+zrER725lLReU7KprmCWGJejW4k/ZAtGR6Veij9DoTcUvHTLn1OzpaDr2fkop/lJICw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection

@section('vendor-script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta3/js/bootstrap-select.js" integrity="sha512-ndehf3lK6GqdbSjARTyQyamMu2k6VcKG9yG+uza6TBtFX40SALRDvbw/CsdxgqSk5p3k9gvZnbzmcP1JOcRUGQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@endsection

@section('content')

    <h4 class="fw-bold py-3 mb-3 row justify-content-between">
        <div class="col-md-auto">
            <span class="text-muted fw-light">{{ __("user.breadcrumb") }} /</span> {{ __("user.browse.{$type}") }}
        </div>
        {{-- <div class="col-md-auto">
            <button type="button" class="btn btn-primary" id="create">
                <span class="tf-icons bx bx-plus"></span>{{ __("user.actions.create") }}
            </button>
        </div> --}}
    </h4>

    <!-- Basic Bootstrap Table -->
    <div class="card">
        <div class="table-responsive text-nowrap">
            <div class="table-header row justify-content-between">
                <h5 class="col-md-auto">{{ __("user.table.header.{$type}") }}</h5>
            </div>
            <table class="table" id="laravel_datatable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ __("user.table.name") }}</th>
                        <th>{{ __("user.table.role") }}</th>
                        <th>{{ __("user.table.email") }}</th>
                        <th>{{ __("user.table.phone") }}</th>
                        <th>{{ __("user.table.status") }}</th>
                        <th>{{ __("user.table.created_at") }}</th>
                        <th>{{ __("user.table.actions") }}</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    @include("content.user.create")
    @include("content.user.update")
    @include("content.user.delete")
    @include("content.user.suspend")
    @include("content.user.activate")
@endsection


@section('page-script')
    <script>
        $(document).ready(function() {
            
            load_data();
            $('.selectpicker').selectpicker();
            function load_data() {
                //$.fn.dataTable.moment( 'YYYY-M-D' );
                var table = $('#laravel_datatable').DataTable({
                    language: {{ Js::from(__('datatable')) }},
                    responsive: true,
                    processing: true,
                    serverSide: true,
                    pageLength: 10,

                    ajax: {
                        url: '{{ url("user/list") }}',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            role: "{{ request('role') }}",
                            status: "{{ request('status') }}"
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
                                    return '<span class="badge bg-label-teal">{{ __('user.statuses.active') }}</span>';
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
                    url: '{{ url("user/create") }}',
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
                    url: '{{ url("user/get") }}',
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
                    url: '{{ url("user/update") }}',
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


            $(document.body).on('click', '.activate', function() {

                var id = $(this).data('id');
                var modal = $('#activate-modal');
                modal.find('input[name="id"]').val(id);
                
                $.ajax({
                    url: '{{ url("user/update") }}',
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
                        if (response.data) {

                            modal.find('select').selectpicker('destroy');

                            modal.find('option[value="profile"]').prop('disabled', !response.data.profile);
                            modal.find('option[value="truck"]').prop('disabled', !response.data.truck);
                            modal.find('option[value="invoice"]').prop('disabled', !response.data.invoice);
                            
                            modal.find('select').selectpicker('render');
                            
                            
                            modal.modal('show');
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

            $(document.body).on('click', '.suspend', function() {

                var id = $(this).data('id');
                var modal = $('#suspend-modal');
                modal.find('input[name="id"]').val(id);
                
                $.ajax({
                    url: '{{ url("user/update") }}',
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
                        if (response.data) {

                            modal.find('select').selectpicker('destroy');

                            modal.find('option[value="profile"]').prop('disabled', !response.data.profile);
                            modal.find('option[value="truck"]').prop('disabled', !response.data.truck);
                            modal.find('option[value="invoice"]').prop('disabled', !response.data.invoice);
                            
                            modal.find('select').selectpicker('render');

                            modal.modal('show');
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

            $('#activate-submit').on('click', function() {

                var modal = $("#activate-modal");

                if (modal.find('input[name="confirmed"]').prop('checked')) {

                    modal.modal("hide");

                    var formdata = new FormData($("#activate-form")[0]);

                    $.ajax({
                        url: '{{ url("user/update") }}',
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
                                    /* $('#laravel_datatable').DataTable().ajax
                                        .reload(); */
                                        location.reload();
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

            $('#suspend-submit').on('click', function() {

                var modal = $("#suspend-modal");

                if (modal.find('input[name="confirmed"]').prop('checked')) {

                    modal.modal("hide");

                    var formdata = new FormData($("#suspend-form")[0]);
/* formdata.append('types', modal.find('.selectpicker').val()); */
  
                    $.ajax({
                        url: '{{ url("user/update") }}',
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
                                    /* $('#laravel_datatable').DataTable().ajax
                                        .reload(); */
                                        location.reload();
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

        });
    </script>
@endsection
