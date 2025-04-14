<div class="modal fade" id="create-modal" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="fw-bold py-1 mb-1">{{ __("category.modals.create") }}</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" onsubmit="event.preventDefault()" action="#"
                    enctype="multipart/form-data" id="create-form">

                    <div class="card-body">
                      <div class="d-flex align-items-start align-items-sm-center gap-4">
                          <div hidden><img src="https://placehold.co/100?text=No+Image" alt="image"
                                  class="d-block rounded old-image" height="100" width="100" /> </div>
                          <img src="https://placehold.co/100?text=No+Image" alt="image"
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

                    <hr class="my-3">

                    <div class="mb-3">
                        <label for="name" class="form-label">{{ __("category.labels.name_ar") }}</label>
                        <input type="text" class="form-control" name="name_ar"
                            placeholder="{{ __("category.placeholders.name_ar") }}" autofocus>
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">{{ __("category.labels.name_en") }}</label>
                        <input type="text" class="form-control" name="name_en"
                            placeholder="{{ __("category.placeholders.name_en") }}" autofocus>
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">{{ __("category.labels.name_fr") }}</label>
                        <input type="text" class="form-control" name="name_fr"
                            placeholder="{{ __("category.placeholders.name_fr") }}" autofocus>
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
