<div class="modal fade" id="send-modal" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="fw-bold py-1 mb-1">{{ __('notice.modals.send') }}</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" onsubmit="event.preventDefault()" action="#" id="send-form">

          <input type="hidden" name="id">

          <div class="alert alert-purple mb-4">
            <h5 class="text-center">{{ __('notice.send.confirmation') }}</h5>
            <p class="text-center mb-0">{{ __('notice.send.notice') }}</p>
          </div>


          <div class="mb-3">
            <label for="recipient_type" class="form-label">{{ __('notice.labels.recipient_type') }} <span class="text-danger">*</span></label>
            <select class="form-select" name="recipient_type" required>
              <option value="all">{{ __('notice.recipients.all') }}</option>
              <option value="renters">{{ __('notice.recipients.renters') }}</option>
              <option value="drivers">{{ __('notice.recipients.drivers') }}</option>
            </select>
          </div>


          <div class="mb-3">
            <label for="delivery_method" class="form-label">{{ __('notice.labels.delivery_method') }} <span class="text-danger">*</span></label>
            <select class="form-select" name="delivery_method" required>
              <option value="app_only">{{ __('notice.delivery.app_only') }}</option>
              <option value="app_and_push">{{ __('notice.delivery.app_and_push') }}</option>
            </select>
          </div>

          <div class="mb-3">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" name="confirmed" required>
              <label class="form-check-label" for="confirmed">
                {{ __('notice.send.confirm_checkbox') }}
              </label>
            </div>
          </div>

          <div class="d-flex justify-content-center gap-2">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
              {{ __('app.cancel') }}
            </button>
            <button type="submit" class="btn btn-purple" id="send-submit">
              <i class="fas fa-paper-plane me-2"></i>
              {{ __('app.send') }}
            </button>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>
