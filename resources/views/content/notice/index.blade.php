@extends('layouts/contentNavbarLayout')

@section('title', __("notice.title"))

@section('content')

    <h4 class="fw-bold py-3 mb-3 row justify-content-between">
        <div class="col-md-auto">
            <span class="text-muted fw-light">{{ __("notice.breadcrumb") }} /</span> {{ __("notice.browse") }}
        </div>
        <div class="col-md-auto">
            <button type="button" class="btn btn-primary" id="create">
                <span class="tf-icons bx bx-plus"></span>{{ __("notice.actions.create") }}
            </button>
        </div>
    </h4>

    <!-- Basic Bootstrap Table -->
    <div class="card">
        <div class="table-responsive text-nowrap">
            <div class="table-header row justify-content-between">
                <h5 class="col-md-auto">{{ __("notice.table.header") }}</h5>
            </div>
            <table class="table" id="laravel_datatable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ __("notice.table.title") }}</th>
                        <th>{{ __("notice.table.priority") }}</th>
                        <th>{{ __("notice.table.created_at") }}</th>
                        <th>{{ __("notice.table.actions") }}</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    @include("content.notice.create")
    @include("content.notice.update")
    @include("content.notice.delete")
    @include("content.notice.send")


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
                        url: '{{ url("notice/list") }}',
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
                            data: 'title',
                            name: 'title'
                        },

                        {
                            data: 'priority',
                            name: 'priority',
                            render: function(data) {
                                if (data == 1) {
                                    return '<span class="badge bg-label-warning">{{ __('notice.priority.required') }}</span>';
                                } else {
                                    return '<span class="badge bg-label-info">{{ __('notice.priority.optional') }}</span>';
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
                    url: '{{ url("notice/create") }}',
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
                    url: '{{ url("notice/get") }}',
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
                            modal.find('input[name="title_en"]').val(response.data.title_en);
                            modal.find('input[name="title_ar"]').val(response.data.title_ar);
                            modal.find('input[name="title_fr"]').val(response.data.title_fr);

                            modal.find('textarea[name="content_en"]').val(response.data
                                .content_en);
                            modal.find('textarea[name="content_ar"]').val(response.data
                                .content_ar);
                            modal.find('textarea[name="content_fr"]').val(response.data
                                .content_fr);

                            modal.find('input[name="priority"]').val(response.data.priority);

                            modal.modal("show");
                        }
                    }
                });
            });


            $('#update-submit').on('click', function() {

                $("#update-modal").modal("hide");

                var formdata = new FormData($("#update-form")[0]);

                $.ajax({
                    url: '{{ url("notice/update") }}',
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
                    url: '{{ url("notice/delete") }}',
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
                        url: '{{ url("notice/delete") }}',
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

            $(document.body).on('click', '.send', function() {

                var id = $(this).data('id');
                var modal = $('#send-modal');
                modal.find('input[name="id"]').val(id);
                modal.modal('show');

            });

            $('#send-submit').on('click', function() {

                var modal = $("#send-modal");

                if (modal.find('input[name="confirmed"]').prop('checked')) {

                    modal.modal("hide");

                    var formdata = new FormData($("#send-form")[0]);

                    $.ajax({
                        url: '{{ url("notice/send") }}',
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

        });
    </script>
@endsection
