<div class="modal fade" id="reject-modal" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="fw-bold py-1 mb-1">{{ __("{$model}.modals.reject") }}</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" onsubmit="event.preventDefault()" action="#" id="reject-form">

          <input type="hidden" name="id">
          <input type="hidden" name="status" value="suspended">

          <div class="alert alert-warning mb-4">
            <h5 class="text-center">{{ __('user.reject.confirmation') }}</h5>
            <p class="text-center mb-0">{{ __('user.reject.warning') }}</p>
          </div>

          <div class="mb-3">
            <label for="rejection_reason" class="form-label">{{ __('user.reject.reason') }} <span class="text-danger">*</span></label>
            <select class="form-select" name="suspended_for" required>
              <option value="admin">{{ __('user.reasons.admin') }}</option>
              <option value="profile">{{ __('user.reasons.profile') }}</option>
              <option value="truck">{{ __('user.reasons.truck') }}</option>
              <option value="invoice">{{ __('user.reasons.invoice') }}</option>
            </select>
          </div>

          <div class="mb-3">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" name="confirmed" required>
              <label class="form-check-label" for="confirmed">
                {{ __('user.reject.confirm_checkbox') }}
              </label>
            </div>
          </div>

          <div class="d-flex justify-content-center gap-2">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
              {{ __('app.cancel') }}
            </button>
            <button type="submit" id="reject-submit" name="submit" class="btn btn-warning reject-submit">
              {{ __('app.submit') }}
            </button>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>