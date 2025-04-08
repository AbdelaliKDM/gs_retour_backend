@extends('layouts/contentNavbarLayout')

@section('title', __('Account'))

@section('content')
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">{{ __('user.account_settings') }} /</span> {{ __('user.account') }}
    </h4>

    <div class="row">
        <div class="col-md-12">
            <!-- Profile Details -->
            <form id="formAccountSettings" method="POST">
                <div class="card mb-4">
                    <h5 class="card-header">{{ __('user.profile_details') }}</h5>
                    <div class="card-body">
                      <div class="d-flex align-items-start align-items-sm-center gap-4">
                          <div hidden><img src="{{ auth()->user()->image_url ?? 'https://placehold.co/100?text=No+Image' }}" alt="image"
                                  class="d-block rounded old-image" height="100" width="100" /> </div>
                          <img src="{{ auth()->user()->image_url ?? 'https://placehold.co/100?text=No+Image' }}" alt="image"
                              class="d-block rounded uploaded-image" height="100" width="100" />
                          <div class="button-wrapper">
                            <label class="btn btn-primary" tabindex="0">
                              <span class="d-none d-sm-block">{{ __('app.image.upload') }}</span>
                              <i class="bx bx-upload d-block d-sm-none"></i>
                              <input class="image-input" type="file" name="image" hidden
                                  accept="image/png, image/jpeg" />
                          </label>
                              <button type="button" class="btn btn-outline-secondary image-reset">
                                  <i class="bx bx-reset d-block d-sm-none"></i>
                                  <span class="d-none d-sm-block">{{ __('app.image.reset') }}</span>
                              </button>
                              <br>
                              {{-- <small class="text-muted mb-0">Allowed JPG, GIF or PNG. Max size of 800K</small> --}}
                          </div>
                      </div>
                  </div>
                    <hr class="my-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="firstName" class="form-label">{{ __('user.labels.name') }}</label>
                                <input class="form-control" type="text" name="name"
                                    value="{{ auth()->user()->name }}" autofocus />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="email" class="form-label">{{ __('user.labels.email') }}</label>
                                <input class="form-control" type="text" name="email"
                                    value="{{ auth()->user()->email }}" />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label" for="phoneNumber">{{ __('user.labels.phone') }}</label>
                                <input type="text"" name="phone" class="form-control"
                                    value="{{ auth()->user()->phone }}" />
                            </div>
                        </div>
                        <div class="mt-2">
                            <button type="submit" class="btn btn-primary me-2">{{ __('app.save') }}</button>
                            <button type="reset" class="btn btn-outline-secondary">{{ __('app.cancel') }}</button>
                        </div>
                    </div>
                </div>
            </form>

            <!-- Change Password -->
            <div class="card mb-4">
                <h5 class="card-header">{{ __('user.change_password') }}</h5>
                <div class="card-body">
                    <form id="formChangePassword" method="POST" onsubmit="event.preventDefault()" action="#"
                        enctype="multipart/form-data">
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="old_password" class="form-label">{{ __('user.current_password') }}</label>
                                <input class="form-control" type="password" name="old_password" />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="new_password" class="form-label">{{ __('user.new_password') }}</label>
                                <input class="form-control" type="password" name="new_password" />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="new_password_confirmation"
                                    class="form-label">{{ __('user.confirm_new_password') }}</label>
                                <input class="form-control" type="password" name="new_password_confirmation" />
                            </div>
                        </div>
                        <div class="mt-2">
                            <button type="submit" id="btnChangePassword"
                                class="btn btn-primary me-2">{{ __('app.change') }}</button>
                            <button type="reset" class="btn btn-outline-secondary">{{ __('app.cancel') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-script')
    <script>
        $(document).ready(function() {
            // Profile Update Form
            $('#formAccountSettings').on('submit', function(e) {
                e.preventDefault();
                var formData = new FormData(this);

                $.ajax({
                    url: "{{ url('account/update') }}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST',
                    data: formData,
                    dataType: 'JSON',
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.status == 1) {
                            Swal.fire({
                                title: "{{ __('Success') }}",
                                text: "{{ __('Profile updated successfully') }}",
                                icon: 'success',
                                confirmButtonText: "{{ __('Ok') }}"
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

            // Change Password Form
            $('#btnChangePassword').on('click', function() {
                var formData = new FormData($('#formChangePassword')[0]);

                $.ajax({
                    url: "{{ url('account/password/change') }}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST',
                    data: formData,
                    dataType: 'JSON',
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.status == 1) {
                            Swal.fire({
                                title: "{{ __('Success') }}",
                                text: "{{ __('Password changed successfully') }}",
                                icon: 'success',
                                confirmButtonText: "{{ __('Ok') }}"
                            }).then((result) => {
                              window.location.href = "{{url('auth/logout')}}";
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
