@extends('layouts/contentNavbarLayout')

@section('title', __("subcategory.title"))

@section('content')

    <h4 class="fw-bold py-3 mb-3 row justify-content-between">
        <div class="col-md-auto">
            <span class="text-muted fw-light">{{ __("subcategory.breadcrumb") }} /</span> {{ __("subcategory.browse") }}
        </div>
        <div class="col-md-auto">
            <button type="button" class="btn btn-primary" id="create">
                <span class="tf-icons bx bx-plus"></span>{{ __("subcategory.actions.create") }}
            </button>
        </div>
    </h4>

    <!-- Basic Bootstrap Table -->
    <div class="card">
        <div class="table-responsive text-nowrap">
            <div class="table-header row justify-content-between">
                <h5 class="col-md-auto">{{ __("subcategory.table.header") }}</h5>
            </div>
            <table class="table" id="laravel_datatable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ __("subcategory.table.name_en") }}</th>
                        <th>{{ __("subcategory.table.name_ar") }}</th>
                        <th>{{ __("subcategory.table.name_fr") }}</th>
                        <th>{{ __("subcategory.table.image") }}</th>
                        <th>{{ __("subcategory.table.category") }}</th>
                        <th>{{ __("subcategory.table.created_at") }}</th>
                        <th>{{ __("subcategory.table.actions") }}</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    @include("content.subcategory.create")
    @include("content.subcategory.update")
    @include("content.subcategory.delete")
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
                        url: '{{ url("subcategory/list") }}',
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
                            data: 'name_en',
                            name: 'name_en'
                        },

                        {
                            data: 'name_ar',
                            name: 'name_ar'
                        },

                        {
                            data: 'name_fr',
                            name: 'name_fr'
                        },

                        {
                            data: 'image',
                            name: 'image',
                            render: function(data) {
                                return '<img src="' + data + '" class="rounded" width="50">';
                            }
                        },

                        {
                            data: 'category',
                            name: 'category'
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
                    url: '{{ url("subcategory/create") }}',
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
                    url: '{{ url("subcategory/get") }}',
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
                            modal.find('select[name="category_id"]').val(response.data.category_id);
                            modal.find('input[name="name_en"]').val(response.data.name_en);
                            modal.find('input[name="name_ar"]').val(response.data.name_ar);
                            modal.find('input[name="name_fr"]').val(response.data.name_fr);

                            if (response.data.image) {
                                modal.find('.uploaded-image').attr('src', response.data.image);
                                modal.find('.old-image').attr('src', response.data.image);
                            }

                            modal.modal("show");
                        }
                    }
                });
            });


            $('#update-submit').on('click', function() {

                $("#update-modal").modal("hide");

                var formdata = new FormData($("#update-form")[0]);

                $.ajax({
                    url: '{{ url("subcategory/update") }}',
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
                    url: '{{ url("subcategory/delete") }}',
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
                        url: '{{ url("subcategory/delete") }}',
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

            $(document).on('change', '.image-input', function() {
                const container = $(this).closest('.card-body');
                const fileInput = this;
                if (fileInput.files[0]) {
                    container.find('.uploaded-image').attr('src', window.URL.createObjectURL(fileInput
                        .files[0]));
                }
            });

            $(document).on('click', '.image-reset', function() {
                const container = $(this).closest('.card-body');
                container.find('.image-input').val('');
                const oldSrc = container.find('.old-image').attr('src');
                container.find('.uploaded-image').attr('src', oldSrc);
            });

        });
    </script>
@endsection
