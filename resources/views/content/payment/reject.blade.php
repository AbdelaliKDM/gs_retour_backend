<div class="modal fade" id="reject-modal" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="fw-bold py-1 mb-1">{{ __('payment.modals.reject') }}</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" onsubmit="event.preventDefault()" action="#" id="reject-form">
          <input type="hidden" name="id">
          <input type="hidden" name="status" value="failed">
          <div class="alert alert-warning mb-4">
            <h5 class="text-center">{{ __('payment.reject.confirmation') }}</h5>
            <p class="text-center mb-0">{{ __('payment.reject.notice') }}</p>
          </div>

          <div class="mb-3">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" name="confirmed" required>
              <label class="form-check-label" for="confirmed">
                {{ __('payment.reject.confirm_checkbox') }}
              </label>
            </div>
          </div>

          <div class="d-flex justify-content-center gap-2">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
              {{ __('app.cancel') }}
            </button>
            <button type="submit" class="btn btn-warning" id="reject-submit">
              {{ __('app.submit') }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>