<div class="modal fade" id="renter-info-modal" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">{{ __("user.modals.info") }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <div class="text-center mb-3">
              <img src="https://placehold.co/100?text=User" alt="User"
                  class="user-image rounded-circle" width="80" height="80">
          </div>

          <div class="mb-3">
              <label class="form-label fw-semibold">{{ __('user.labels.name') }}</label>
              <p class="user-name">-</p>
          </div>

          <div class="mb-3">
              <label class="form-label fw-semibold">{{ __('user.labels.phone') }}</label>
              <p class="user-phone">-</p>
          </div>

          <div class="mb-3">
              <label class="form-label fw-semibold">{{ __('user.labels.email') }}</label>
              <p class="user-email">-</p>
          </div>

          <!-- User Documents -->
          <div class="mb-3">
              <label class="form-label fw-semibold">{{ __('user.labels.id_card') }}</label>
              <p><a href="#" class="btn btn-sm btn-primary id-card-link" target="_blank">
                      <i class="bx bx-download me-1"></i>{{ __('app.download') }}
                  </a></p>
          </div>

          <div class="mb-3">
              <label class="form-label fw-semibold">{{ __('user.labels.id_card_selfie') }}</label>
              <p><a href="#" class="btn btn-sm btn-primary id-card-selfie-link" target="_blank">
                      <i class="bx bx-download me-1"></i>{{ __('app.download') }}
                  </a></p>
          </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>