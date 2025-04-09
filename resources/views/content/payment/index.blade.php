@extends('layouts/contentNavbarLayout')

@section('title', __("{$model}.title.{$type}"))

@section('content')

    <h4 class="fw-bold py-3 mb-3 row justify-content-between">
        <div class="col-md-auto">
            <span class="text-muted fw-light">{{ __("{$model}.breadcrumb") }} /</span> {{ __("{$model}.browse.{$type}") }}
        </div>
    </h4>

    <!-- Basic Bootstrap Table -->
    <div class="card">
        <div class="table-responsive text-nowrap">
            <div class="table-header row justify-content-between">
                <h5 class="col-md-auto">{{ __("{$model}.table.header.{$type}") }}</h5>
            </div>
            <table class="table" id="laravel_datatable">
                <thead>
                    <tr>
                      <th>{{ __("{$model}.table.id") }}</th>
                        <th>{{ __("{$model}.table.user") }}</th>
                        <th>{{ __("{$model}.table.amount") }}</th>
                        <th>{{ __("{$model}.table.type") }}</th>
                        <th>{{ __("{$model}.table.status") }}</th>
                        <th>{{ __("{$model}.table.created_at") }}</th>
                        <th>{{ __("{$model}.table.actions") }}</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    @include("content.{$model}.info")
    @include("content.{$model}.delete")
    @include("content.{$model}.accept")
    @include("content.{$model}.reject")
    @include("content.{$model}.invoice-info")
    @include("content.{$model}.wallet-info")

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
                        data: {
                            type: "{{ $type }}"
                        },
                        type: 'POST',
                    },

                    columns: [

                        {
                            data: 'id',
                            name: 'id',
                            render:function(data) {
                              return `#${data}`;
                            }
                        },

                        {
                            data: 'user',
                            name: 'user'
                        },

                        {
                            data: 'amount',
                            name: 'amount'
                        },

                        {
                            data: 'type',
                            name: 'type',
                            render: function(data) {
                                if (data == 'wallet') {
                                    return '<span class="badge bg-label-warning">{{ __('payment.types.wallet') }}</span>';
                                }
                                if (data == 'invoice') {
                                    return '<span class="badge bg-label-info">{{ __('payment.types.invoice') }}</span>';
                                }
                            },
                        },

                        {
                            data: 'status',
                            name: 'status',
                            render: function(data) {
                                if (data == 'pending') {
                                    return '<span class="badge bg-label-secondary">{{ __('payment.statuses.pending') }}</span>';
                                }
                                if (data == 'failed') {
                                    return '<span class="badge bg-label-danger">{{ __('payment.statuses.failed') }}</span>';
                                }
                                if (data == 'paid') {
                                    return '<span class="badge bg-label-teal">{{ __('payment.statuses.paid') }}</span>';
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
                            modal.find('input[name="name_en"]').val(response.data.name_en);
                            modal.find('input[name="name_ar"]').val(response.data.name_ar);
                            modal.find('input[name="name_fr"]').val(response.data.name_fr);

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
                                    '<span class="badge bg-label-danger rounded-pill">' +
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
                            var modal = data.type == 'wallet' ? $('#wallet-info-modal') : $(
                                '#invoice-info-modal');

                            // Populate payer information
                            modal.find('.payer-name').text(data.user.name || '-');
                            modal.find('.payer-phone').text(data.user.phone || '-');
                            modal.find('.payer-email').text(data.user.email || '-');

                            if (data.user.image) {
                                modal.find('.payer-image').attr('src', data.user.image);
                            } else {
                                modal.find('.payer-image').attr('src',
                                    'https://placehold.co/100?text=User');
                            }

                            // Populate payment information

                            modal.find('.payment-amount').text(data.amount_money || '-');


                            if (data.type === 'wallet') {
                                statusClass = 'bg-label-warning';
                            } else if (data.type === 'invoice') {
                                statusClass = 'bg-label-info';
                            } else {
                                var statusClass = 'bg-label-secondary';
                            }

                            modal.find('.payment-type')
                                .removeClass('bg-label-secondary bg-label-teal bg-label-warning bg-label-danger')
                                .addClass(statusClass)
                                .text(data.type_name || '-');

                            // Set status with appropriate badge color

                            if (data.status === 'paid') {
                                statusClass = 'bg-label-teal';
                            } else if (data.status === 'pending') {
                                statusClass = 'bg-label-warning';
                            } else if (data.status === 'failed') {
                                statusClass = 'bg-label-danger';
                            } else {
                                var statusClass = 'bg-label-secondary';
                            }

                            modal.find('.payment-status')
                                .removeClass('bg-label-secondary bg-label-teal bg-label-warning bg-label-danger')
                                .addClass(statusClass)
                                .text(data.status_name || '-');

                            if (data.payment_method === 'chargily') {
                                statusClass = 'bg-label-teal';
                            } else if (data.payment_method === 'wallet') {
                                statusClass = 'bg-label-warning';
                            } else if (data.payment_method === 'ccp') {
                                statusClass = 'bg-label-blue';
                            } else if (data.payment_method === 'baridi') {
                                statusClass = 'bg-label-info';
                            } else {
                                var statusClass = 'bg-label-secondary';
                            }

                            modal.find('.payment-method')
                                .removeClass(
                                    'bg-label-blue bg-label-secondary bg-label-teal bg-label-warning bg-label-danger bg-label-info bg-label-teal'
                                )
                                .addClass(statusClass)
                                .text(data.payment_method_name || '-');

                            modal.find('.payment-paid-at').text(data.paid_at || '-');
                            modal.find('.payment-account-number').text(data.account || '-');

                            if (data.receipt) {
                                modal.find('.payment-receipt').attr('href', data.receipt)
                                    .removeClass('btn-outline-secondary disabled')
                                    .addClass('btn-outline-primary')
                                    .attr('target', '_blank')
                                    .find('span').text("{{ __('payment.labels.receipt') }}");
                            } else {
                                modal.find('.payment-receipt').removeAttr('href')
                                    .removeClass('btn-outline-primary')
                                    .addClass('btn-outline-secondary disabled')
                                    .removeAttr('target')
                                    .find('span').text("{{ __('payment.labels.receipt') }}");
                            }

                            if (data.type == 'wallet') {
                                // Wallet information
                                modal.find('.wallet-balance').text(
                                    `${data.payable.balance_money}`);
                                modal.find('.wallet-charges').text(data.payable.charges);
                            } else if (data.type == 'invoice') {
                                // Invoice information
                                modal.find('.invoice-total-amount').text(
                                    `${data.payable.total_amount_money}`);
                                modal.find('.invoice-tax-amount').text(
                                    `${data.payable.tax_amount_money}`);
                                modal.find('.invoice-month').text(data.payable.month + ' ' +
                                    data.payable.year);
                            }

                            modal.modal('show');
                        }
                    }
                });
            });


            $(document.body).on('click', '.accept', function() {

                var id = $(this).data('id');
                var modal = $('#accept-modal');
                modal.find('input[name="id"]').val(id);
                modal.modal('show');

            });

            $(document.body).on('click', '.reject', function() {

                var id = $(this).data('id');
                var modal = $('#reject-modal');
                modal.find('input[name="id"]').val(id);
                modal.modal('show');

            });

            $('#accept-submit').on('click', function() {

                var modal = $("#accept-modal");

                if (modal.find('input[name="confirmed"]').prop('checked')) {

                    modal.modal("hide");

                    var formdata = new FormData($("#accept-form")[0]);

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
                }
            });

            $('#reject-submit').on('click', function() {

                var modal = $("#reject-modal");

                if (modal.find('input[name="confirmed"]').prop('checked')) {

                    modal.modal("hide");

                    var formdata = new FormData($("#reject-form")[0]);

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
                }
            });

        });
    </script>
@endsection
