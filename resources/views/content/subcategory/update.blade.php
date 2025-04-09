<div class="modal fade" id="update-modal" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="fw-bold py-1 mb-1">{{ __("{$model}.modals.update") }}</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" onsubmit="event.preventDefault()" action="#"
                    enctype="multipart/form-data" id="update-form">

                    <input type="hidden" id="id" name="id">

                    <div class="card-body">
                        <div class="d-flex align-items-start align-items-sm-center gap-4">
                            <div hidden><img src="https://placehold.co/100?text=No+Image" alt="image"
                                    class="d-block rounded old-image" height="100" width="100" /> </div>
                            <img src="https://placehold.co/100?text=No+Image" alt="image"
                                class="d-block rounded uploaded-image" height="100" width="100" />
                            <div class="button-wrapper">
                                <label class="btn btn-cyan" tabindex="0">
                                    <span class="d-none d-sm-block">{{ __('app.image.upload') }}</span>
                                    <i class="bx bx-upload d-block d-sm-none"></i>
                                    <input class="image-input" type="file" id='image' name="image" hidden
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

                    <hr class="my-3">

                    <div class="mb-3">
                        <label for="name" class="form-label">{{ __("{$model}.labels.name_ar") }}</label>
                        <input type="text" class="form-control" name="name_ar">
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">{{ __("{$model}.labels.name_en") }}</label>
                        <input type="text" class="form-control" name="name_en">
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">{{ __("{$model}.labels.name_fr") }}</label>
                        <input type="text" class="form-control" name="name_fr">
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="category_id">{{ __("{$model}.labels.category") }}</label>
                        <select class="form-select" name="category_id">
                            <option disabled selected value=""> {{ __("{$model}.placeholders.category") }}
                            </option>
                            @foreach ($categories as $key => $value)
                                <option value="{{ $key }}"> {{ $value }} </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3 text-center" >
                        <button type="submit" id="update-submit" name="submit"
                            class="btn btn-cyan">{{ __('app.update') }}</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
