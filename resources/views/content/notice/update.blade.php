<div class="modal fade" id="update-modal" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document"> <!-- Changed to modal-xl for two columns -->
      <div class="modal-content">
          <div class="modal-header">
              <h4 class="fw-bold py-1 mb-1">{{ __('notice.modals.update') }}</h4>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
              <form class="form-horizontal" onsubmit="event.preventDefault()" action="#" id="update-form">
                  <div class="row">

                    <input type="hidden" name="id">

                      <div class="col-md-6">

                          <div class="mb-3">
                              <label class="form-label">{{ __('notice.labels.title_ar') }} <span class="text-danger">*</span></label>
                              <input type="text" class="form-control" name="title_ar"
                                  placeholder="{{ __('notice.placeholders.title_ar') }}">
                          </div>

                          <div class="mb-3">
                              <label class="form-label">{{ __('notice.labels.title_en') }} <span class="text-danger">*</span></label>
                              <input type="text" class="form-control" name="title_en"
                                  placeholder="{{ __('notice.placeholders.title_en') }}">
                          </div>

                          <div class="mb-5">
                              <label class="form-label">{{ __('notice.labels.title_fr') }}</label>
                              <input type="text" class="form-control" name="title_fr"
                                  placeholder="{{ __('notice.placeholders.title_fr') }}">
                          </div>

                          <hr class="my-3">

                          <div class="mb-3">
                              <label class="form-label">{{ __('notice.labels.priority') }}</label>
                              <select class="form-select" name="priority">
                                  <option value="0">{{ __('notice.priority.optional') }}</option>
                                  <option value="1">{{ __('notice.priority.required') }}</option>
                              </select>
                              <small class="text-muted">{{ __('notice.hints.priority') }}</small>
                          </div>

                      </div>

                      <div class="col-md-6">

                          <div class="mb-3">
                              <label class="form-label">{{ __('notice.labels.content_ar') }} <span class="text-danger">*</span></label>
                              <textarea class="form-control" name="content_ar" rows="3"
                                  placeholder="{{ __('notice.placeholders.content_ar') }}"></textarea>
                          </div>

                          <div class="mb-3">
                              <label class="form-label">{{ __('notice.labels.content_en') }} <span class="text-danger">*</span></label>
                              <textarea class="form-control" name="content_en" rows="3"
                                  placeholder="{{ __('notice.placeholders.content_en') }}"></textarea>
                          </div>

                          <div class="mb-3">
                              <label class="form-label">{{ __('notice.labels.content_fr') }}</label>
                              <textarea class="form-control" name="content_fr" rows="3"
                                  placeholder="{{ __('notice.placeholders.content_fr') }}"></textarea>
                          </div>
                      </div>
                  </div>

                  <div class="row mt-4">
                      <div class="col-12">
                          <div class="d-flex justify-content-center gap-2">
                              <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                  {{ __('app.cancel') }}
                              </button>
                              <button type="submit" class="btn btn-primary" id="update-submit">
                                  {{ __('app.update') }}
                              </button>
                          </div>
                      </div>
                  </div>
              </form>
          </div>
      </div>
  </div>
</div>