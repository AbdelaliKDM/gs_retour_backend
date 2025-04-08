@extends('layouts/contentNavbarLayout')

@section('title', __("{$model}.title"))

@section('content')

    <h4 class="fw-bold py-3 mb-3 row justify-content-between">
        <div class="col-md-auto">
            <span class="text-muted fw-light">{{ __("{$model}.breadcrumb") }} /</span> {{ __("{$model}.browse") }}
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
                        <th>{{ __("{$model}.table.title") }}</th>
                        <th>{{ __("{$model}.table.priority") }}</th>
                        <th>{{ __("{$model}.table.created_at") }}</th>
                        <th>{{ __("{$model}.table.actions") }}</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    {{-- @include("content.{$model}.delete") --}}


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
                            data: 'title',
                            name: 'title'
                        },

                        {
                            data: 'priority',
                            name: 'priority',
                            render: function(data) {
                                if (data == 1) {
                                    return '<span class="badge bg-label-warning">{{ __('notice.types.required') }}</span>';
                                }else{
                                    return '<span class="badge bg-label-info">{{ __('notice.types.optional') }}</span>';
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

      });
    </script>
@endsection
