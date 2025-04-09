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

                    <div class="row mb-3">
                      <div class="col-md-6">
                          <label for="name_ar" class="form-label">{{ __("{$model}.labels.name_ar") }}</label>
                          <input type="text" class="form-control" name="name_ar"
                              placeholder="{{ __("{$model}.placeholders.name_ar") }}" autofocus>
                      </div>
                      <div class="col-md-6">
                          <label for="capacity" class="form-label">{{ __("{$model}.labels.capacity") }}</label>
                          <input type="number" class="form-control" name="capacity"
                              placeholder="{{ __("{$model}.placeholders.capacity") }}">
                      </div>

                  </div>

                  <div class="row mb-3">
                      <div class="col-md-6">
                          <label for="name_en" class="form-label">{{ __("{$model}.labels.name_en") }}</label>
                          <input type="text" class="form-control" name="name_en"
                              placeholder="{{ __("{$model}.placeholders.name_en") }}">
                      </div>
                      <div class="col-md-6">
                          <label for="weight" class="form-label">{{ __("{$model}.labels.weight") }}</label>
                          <input type="number" class="form-control" name="weight"
                              placeholder="{{ __("{$model}.placeholders.weight") }}">
                      </div>
                  </div>

                  <div class="row mb-3">
                      <div class="col-md-6">
                          <label for="name_fr" class="form-label">{{ __("{$model}.labels.name_fr") }}</label>
                          <input type="text" class="form-control" name="name_fr"
                              placeholder="{{ __("{$model}.placeholders.name_fr") }}">
                      </div>
                      <div class="col-md-6">
                          <label class="form-label" for="subcategory_id">{{ __("{$model}.labels.subcategory") }}</label>
                          <select class="form-select" name="subcategory_id">
                              <option disabled selected value=""> {{ __("{$model}.placeholders.subcategory") }}
                              </option>
                              @foreach ($subcategories as $key => $value)
                                  <option value="{{ $key }}"> {{ $value }} </option>
                              @endforeach
                          </select>
                      </div>
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
