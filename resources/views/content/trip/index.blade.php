@extends('layouts/contentNavbarLayout')

@section('title', __("trip.title.{$status}"))

@section('content')

    <h4 class="fw-bold py-3 mb-3 row justify-content-between">
        <div class="col-md-auto">
            <span class="text-muted fw-light">{{ __('trip.breadcrumb') }} /</span> {{ __("trip.browse.{$status}") }}
        </div>
    </h4>

    <!-- Basic Bootstrap Table -->
    <div class="card">
        <div class="table-responsive text-nowrap">
            <div class="table-header row justify-content-between">
                <h5 class="col-md-auto">{{ __("trip.table.header.{$status}") }}</h5>
                <div class="col-md-auto">

                    <select class="form-select filter-select" id="starting_wilaya_id" onchange="load_data()">
                        <option value=""> {{ __('trip.starting_wilaya') }}</option>
                        @foreach ($wilayas as $key => $value)
                            <option value="{{ $key }}"> {{ $value }} </option>
                        @endforeach
                    </select>

                    <i class="bx bx-{{session('locale') == 'ar' ? 'left' : 'right'}}-arrow-alt fs-4 mx-2"></i>

                    <select class="form-select filter-select" id="arrival_wilaya_id" onchange="load_data()">
                        <option value=""> {{ __('trip.arrival_wilaya') }}</option>
                        @foreach ($wilayas as $key => $value)
                            <option value="{{ $key }}"> {{ $value }} </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <table class="table" id="laravel_datatable">
                <thead>
                    <tr>
                        <th>{{ __('trip.table.id') }}</th>
                        <th>{{ __('trip.table.driver') }}</th>
                        <th>{{ __('trip.table.truck') }}</th>
                        <th>{{ __('trip.table.route') }}</th>
                        <th>{{ __('trip.table.distance') }}</th>
                        <th>{{ __('trip.table.status') }}</th>
                        <th>{{ __('trip.table.created_at') }}</th>
                        <th>{{ __('trip.table.actions') }}</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    @include('content.trip.delete')

@endsection

@section('page-script')
    <script>
        function load_data() {
            var table = $('#laravel_datatable');
            table ? table.DataTable().destroy() : null;
            table.DataTable({
                language: {!! file_get_contents(base_path('lang/' . session('locale', 'en') . '/datatable.json')) !!},
                responsive: true,
                processing: true,
                serverSide: true,
                pageLength: 10,

                ajax: {
                    url: '{{ url('trip/list') }}',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: function(d) {
                        return $.extend({}, d, {
                            status: "{{ $status }}",
                            starting_wilaya_id: $('#starting_wilaya_id').val(),
                            arrival_wilaya_id: $('#arrival_wilaya_id').val()
                        });
                    },
                    type: 'POST',
                },

                columns: [{
                        data: 'id',
                        name: 'id',
                        render: function(data) {
                            return `#${data}`;
                        },
                        orderable: false
                    },
                    {
                        data: 'driver',
                        name: 'driver',
                        render: function(data) {
                            return `<a href="/user/${data.id}/info">${data.name}</a>`;
                        }
                    },
                    {
                        data: 'truck',
                        name: 'truck'
                    },
                    {
                        data: 'route',
                        name: 'route'
                    },
                    {
                        data: 'distance',
                        name: 'distance'
                    },
                    {
                        data: 'current_status',
                        name: 'current_status',
                        render: function(data) {
                            if (data == 'pending') {
                                return '<span class="badge bg-label-secondary">{{ __('trip.statuses.pending') }}</span>';
                            }
                            if (data == 'ongoing') {
                                return '<span class="badge bg-label-info">{{ __('trip.statuses.ongoing') }}</span>';
                            }
                            if (data == 'paused') {
                                return '<span class="badge bg-label-warning">{{ __('trip.statuses.paused') }}</span>';
                            }
                            if (data == 'canceled') {
                                return '<span class="badge bg-label-danger">{{ __('trip.statuses.canceled') }}</span>';
                            }
                            if (data == 'completed') {
                                return '<span class="badge bg-label-teal">{{ __('trip.statuses.completed') }}</span>';
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
                        searchable: false,
                        orderable: false
                    }
                ]
            });
        }
        $(document).ready(function() {
            load_data();

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
