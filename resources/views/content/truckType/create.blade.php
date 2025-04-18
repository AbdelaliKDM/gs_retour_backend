<div class="modal fade" id="create-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('truckType.actions.create') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="create-form" method="POST" enctype="multipart/form-data" onsubmit="event.preventDefault()"
                    action="#">
                    @csrf
                    <input type="hidden" name="create" value="1">

                    <div class="row">

                        <div class="col-md-6">

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
                                            <input class="image-input" type="file" id='image' name="image"
                                                hidden accept="image/png, image/jpeg" />
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

                            <hr style="margin-top: 9.25%; margin-bottom: 9.25%;">

                            <div class="mb-3">
                                <label for="capacity" class="form-label">{{ __('truckType.table.capacity') }}</label>
                                <input type="number" id="capacity" name="capacity" class="form-control"
                                    placeholder="{{ __('truckType.placeholders.capacity') }}" />
                            </div>

                            <div class="mb-3">
                                <label for="weight" class="form-label">{{ __('truckType.table.weight') }}</label>
                                <input type="number" id="weight" name="weight" class="form-control"
                                    placeholder="{{ __('truckType.placeholders.weight') }}" />
                            </div>


                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name_en" class="form-label">{{ __('truckType.table.name_en') }}</label>
                                <input type="text" id="name_en" name="name_en" class="form-control"
                                    placeholder="{{ __('truckType.placeholders.name_en') }}" />
                            </div>

                            <div class="mb-3">
                                <label for="name_ar" class="form-label">{{ __('truckType.table.name_ar') }}</label>
                                <input type="text" id="name_ar" name="name_ar" class="form-control"
                                    placeholder="{{ __('truckType.placeholders.name_ar') }}" />
                            </div>

                            <div class="mb-3">
                                <label for="name_fr" class="form-label">{{ __('truckType.table.name_fr') }}</label>
                                <input type="text" id="name_fr" name="name_fr" class="form-control"
                                    placeholder="{{ __('truckType.placeholders.name_fr') }}" />
                            </div>

                            <div class="mb-3">
                                <label for="subcategory_id"
                                    class="form-label">{{ __('truckType.table.subcategory') }}</label>
                                <select id="subcategory_id" name="subcategory_id" class="form-select">
                                    <option disabled selected value="">
                                        {{ __('truckType.placeholders.subcategory') }}
                                    </option>
                                    @foreach ($subcategories as $key => $value)
                                        <option value="{{ $key }}"> {{ $value }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                    </div>

                    <div class="mb-3 text-center">
                        <button type="submit" id="create-submit" name="submit"
                            class="btn btn-primary">{{ __('app.create') }}</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
