
<div class="modal fade" id="delete-modal" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="fw-bold py-1 mb-1">{{ __("{$model}.modals.delete") }}</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" onsubmit="event.preventDefault()" action="#" id="delete-form">

          <input type="hidden" name="id">

          {{-- <div class="text-center mb-4">
            <i class="bx bx-error-circle text-danger" style="font-size: 4rem;"></i>
          </div> --}}

          <div class="alert alert-warning mb-4">
            <h5 class="text-center">{{ __('app.delete_confirmation') }}</h5>
            <p class="text-center mb-0">{{ __('app.delete_warning') }}</p>
          </div>

          <div class="mb-4 related-items-container">
            <h6 class="text-danger">{{ __('app.delete_related_items') }}</h6>
            <ul class="list-group mt-2 related-items-list">
              <!-- Related items will be populated here dynamically -->
            </ul>
          </div>

          <hr class="my-3">

          <div class="mb-3">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" name="confirm_delete" required>
              <label class="form-check-label" for="confirm_delete">
                {{ __('app.delete_confirm_checkbox') }}
              </label>
            </div>
          </div>

          <div class="d-flex justify-content-center gap-2">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
              {{ __('app.cancel') }}
            </button>
            <button type="submit" id="delete-submit" name="submit" class="btn btn-danger delete-submit">
              {{ __('app.delete') }}
            </button>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>