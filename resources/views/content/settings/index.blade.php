@extends('layouts/contentNavbarLayout')

@section('title', __('app.settings'))

@section('content')
    <form class="form-horizontal" onsubmit="event.preventDefault()" action="#" enctype="multipart/form-data" id="form">

        <h4 class="fw-bold py-3 mb-3">
            <span class="text-muted fw-light"></span> {{ __('settings.version') }}
        </h4>


        <div class="row">
            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">{{ __('settings.android') }}</h5>
                        <small class="text-muted float-end">{{ __('settings.android_version') }}</small>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label" for="android_version_number">{{ __('settings.android_version_number') }}</label>
                            <input type="text" class="form-control" name="android_version_number"
                                value="{{ $settings['android_version_number'] ?? '' }}" />
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="android_build_number">{{ __('settings.android_build_number') }}</label>
                            <input type="text" class="form-control" name="android_build_number"
                                value="{{ $settings['android_build_number'] ?? '' }}" />
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="android_priority">{{ __('settings.android_priority') }}</label>
                            <select class="form-select" name="android_priority">
                                <option value="0">{{ __('settings.optional') }}</option>
                                <option value="1" @if ($settings['android_priority'] ?? '') selected @endif>
                                    {{ __('settings.required') }}</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="android_link">{{ __('settings.android_link') }}</label>
                            <textarea class="form-control" name="android_link">{{ $settings['android_link'] ?? '' }}</textarea>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">{{ __('settings.ios') }}</h5>
                        <small class="text-muted float-end">{{ __('settings.ios_version') }}</small>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label" for="ios_version_number">{{ __('settings.ios_version_number') }}</label>
                            <input type="text" class="form-control" name="ios_version_number"
                                value="{{ $settings['ios_version_number'] ?? '' }}" />
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="ios_build_number">{{ __('settings.ios_build_number') }}</label>
                            <input type="text" class="form-control" name="ios_build_number"
                                value="{{ $settings['ios_build_number'] ?? '' }}" />
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="ios_priority">{{ __('settings.ios_priority') }}</label>
                            <select class="form-select" name="ios_priority">
                                <option value="0">{{ __('settings.optional') }}</option>
                                <option value="1" @if ($settings['ios_priority'] ?? '') selected @endif>
                                    {{ __('settings.required') }}</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="ios_link">{{ __('settings.ios_link') }}</label>
                            <textarea class="form-control" name="ios_link">{{ $settings['android_link'] ?? '' }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Truck Information -->
        <h4 class="fw-bold py-3 mb-3">
            <span class="text-muted fw-light"></span> {{ __('user.truck.title') }}
        </h4>
        <div class="card mb-4">
            <div class="card-body">
                <div class="row">
                    @php
                        $truckAttributes = [
                            'serial_number',
                            'gray_card',
                            'driving_license',
                            'insurance_certificate',
                            'insurance_expiry_date',
                            'inspection_certificate',
                            'next_inspection_date',
                            'affiliated_with_agency',
                        ];
                    @endphp

                    @foreach (array_chunk($truckAttributes, 4) as $column)
                        <div class="col-md-6">
                            @foreach ($column as $attribute)
                                <div class="mb-3">
                                    <label class="form-label"
                                        for="{{ $attribute }}">{{ __('user.truck.' . $attribute) }}</label>
                                    <select class="form-select" name="{{ $attribute }}">
                                        <option value="required" @if (($settings[$attribute] ?? '') === 'required') selected @endif>
                                            {{ __('settings.required') }}</option>
                                        <option value="sometimes" @if (($settings[$attribute] ?? '') === 'sometimes') selected @endif>
                                            {{ __('settings.sometimes') }}</option>
                                        <option value="missing" @if (($settings[$attribute] ?? '') === 'missing') selected @endif>
                                            {{ __('settings.missing') }}</option>
                                    </select>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Contact Information -->
        <h4 class="fw-bold py-3 mb-3">
            <span class="text-muted fw-light"></span> {{ __('settings.contact_information') }}
        </h4>
        <div class="card mb-4">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label" for="whatsapp">{{ __('settings.whatsapp') }}</label>
                        <input type="tel" class="form-control" name="whatsapp"
                            value="{{ $settings['phone'] ?? '' }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="email">{{ __('settings.email') }}</label>
                        <input type="email" class="form-control" name="email"
                            value="{{ $settings['email'] ?? '' }}">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label" for="facebook">{{ __('settings.facebook') }}</label>
                        <input type="url" class="form-control" name="facebook"
                            value="{{ $settings['facebook'] ?? '' }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="instagram">{{ __('settings.instagram') }}</label>
                        <input type="url" class="form-control" name="instagram"
                            value="{{ $settings['instagram'] ?? '' }}">
                    </div>
                </div>
            </div>
        </div>

        <!-- Financial Information -->
        <h4 class="fw-bold py-3 mb-3">
            <span class="text-muted fw-light"></span> {{ __('settings.financial_information') }}
        </h4>
        <div class="row">
            <div class="col-md-9">
                <div class="card mb-4">
                    <div class="card-body">
                        <!-- Left side content remains the same -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label" for="ccp">{{ __('settings.ccp') }}</label>
                                <input type="text" class="form-control" name="ccp"
                                    value="{{ $settings['ccp'] ?? '' }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="baridi">{{ __('settings.baridi') }}</label>
                                <input type="text" class="form-control" name="baridi"
                                    value="{{ $settings['baridi'] ?? '' }}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-5">
                                <label class="form-label" for="chargily_pk">{{ __('settings.chargily_pk') }}</label>
                                <input type="text" class="form-control" name="chargily_pk"
                                    value="{{ $settings['chargily_pk'] ?? '' }}">
                            </div>
                            <div class="col-md-5">
                                <label class="form-label" for="chargily_sk">{{ __('settings.chargily_sk') }}</label>
                                <input type="password" class="form-control" name="chargily_sk"
                                    value="{{ $settings['chargily_sk'] ?? '' }}">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label" for="chargily_mode">{{ __('settings.chargily_mode') }}</label>
                                <select class="form-select" name="chargily_mode">
                                    <option value="test" @if (($settings['chargily_mode'] ?? '') === 'test') selected @endif>
                                        {{ __('settings.test') }}</option>
                                    <option value="live" @if (($settings['chargily_mode'] ?? '') === 'live') selected @endif>
                                        {{ __('settings.live') }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="mb-3">
                            {{-- <label class="form-label">{{ __('settings.payment_methods') }}</label> --}}

                            <!-- OTP -->
                            <input type="hidden" name="otp_enabled" value="0">
                            <div class="form-check form-switch my-3">
                                <input class="form-check-input" type="checkbox" name="otp_enabled"
                                    value="1" @if ($settings['otp_enabled'] ?? false) checked @endif>
                                <label class="form-check-label"
                                    for="otp_enabled">{{ __('settings.otp_enabled') }}</label>
                            </div>

                            <!-- Cash Payment -->
                            <input type="hidden" name="ccp_enabled" value="0">
                            <div class="form-check form-switch my-3">
                                <input class="form-check-input" type="checkbox" name="ccp_enabled"
                                    value="1" @if ($settings['ccp_enabled'] ?? false) checked @endif>
                                <label class="form-check-label"
                                    for="ccp_enabled">{{ __('settings.ccp_enabled') }}</label>
                            </div>

                            <!-- Baridi Mob -->
                            <input type="hidden" name="baridi_enabled" value="0">
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" name="baridi_enabled"
                                    value="1" @if ($settings['baridi_enabled'] ?? false) checked @endif>
                                <label class="form-check-label"
                                    for="baridi_enabled">{{ __('settings.baridi_enabled') }}</label>
                            </div>

                            <!-- Chargily -->
                            <input type="hidden" name="chargily_enabled" value="0">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="chargily_enabled"
                                    value="1"
                                    @if ($settings['chargily_enabled'] ?? false) checked @endif>
                                <label class="form-check-label"
                                    for="chargily_enabled">{{ __('settings.chargily_enabled') }}</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <h4 class="fw-bold py-3 mb-3">
            <span class="text-muted fw-light"></span> {{ __('settings.alerts_settings') }}
        </h4>
        <div class="card mb-4">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label" for="pusher_instance_id">{{ __('settings.pusher_instance_id') }}</label>
                        <input type="text" class="form-control" name="pusher_instance_id"
                            value="{{ $settings['pusher_instance_id'] ?? '' }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="pusher_primary_key">{{ __('settings.pusher_primary_key') }}</label>
                        <input type="password" class="form-control" name="pusher_primary_key"
                            value="{{ $settings['pusher_primary_key'] ?? '' }}">
                    </div>
                </div>
            </div>
        </div>

        <!-- Calculation Settings -->
        <h4 class="fw-bold py-3 mb-3">
            <span class="text-muted fw-light"></span> {{ __('settings.calculation_settings') }}
        </h4>
        <div class="card mb-4">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label" for="price_per_km">{{ __('settings.price_per_km') }}</label>
                        <div class="input-group">
                            <input type="number" class="form-control" name="price_per_km"
                                value="{{ $settings['price_per_km'] ?? '' }}">
                            <span class="input-group-text">{{ __('app.currencies.dzd') }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="tax_ratio">{{ __('settings.tax_ratio') }}</label>
                        <div class="input-group">
                            <input type="number" class="form-control" name="tax_ratio"
                                value="{{ $settings['tax_ratio'] ?? '' }}">
                            <span class="input-group-text">%</span>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label" for="min_price">{{ __('settings.min_price') }}</label>
                        <div class="input-group">
                            <input type="number" class="form-control" name="min_price"
                                value="{{ $settings['min_price'] ?? '' }}">
                            <span class="input-group-text">{{ __('app.currencies.dzd') }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="max_price">{{ __('settings.max_price') }}</label>
                        <div class="input-group">
                            <input type="number" class="form-control" name="max_price"
                                value="{{ $settings['max_price'] ?? '' }}">
                            <span class="input-group-text">{{ __('app.currencies.dzd') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mb-3" style="text-align: center">
            <button type="submit" name="submit" id="submit" class="btn btn-primary">{{ __('app.submit') }}</button>
        </div>
    </form>
@endsection

@section('page-script')
    <script>
        $(document).ready(function() {

            $('#submit').on('click', function() {
                var queryString = new FormData($("#form")[0]);
                //console.log(queryString);
                $.ajax({
                    url: '{{ url('settings/update') }}',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST',
                    data: queryString,
                    dataType: 'JSON',
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.status == 1) {
                            Swal.fire(
                                "{{ __('Success') }}",
                                "{{ __('success') }}",
                                'success'
                            );
                        } else {
                            console.log(response.message);
                            Swal.fire(
                                "{{ __('Error') }}",
                                response.message,
                                'error'
                            );
                        }
                    },
                    error: function(data) {
                        var errors = data.responseJSON;
                        console.log(errors);
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
