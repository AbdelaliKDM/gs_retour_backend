
<div class="modal fade" id="info-modal" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="fw-bold py-1 mb-1">{{ __("payment.modals.info") }}</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <!-- Payer Information Column -->
          <div class="col-md-6 border-end">
            <h5 class="mb-3">{{ __("payment.payer_information") }}</h5>

            <div class="text-center mb-3">
              <img src="https://placehold.co/100?text=User" alt="User" class="payer-image rounded-circle" width="80" height="80">
            </div>

            <div class="mb-3">
              <label class="form-label fw-semibold">{{ __("payment.labels.name") }}</label>
              <p class="payer-name">-</p>
            </div>

            <div class="mb-3">
              <label class="form-label fw-semibold">{{ __("payment.labels.phone") }}</label>
              <p class="payer-phone">-</p>
            </div>

            <div class="mb-3">
              <label class="form-label fw-semibold">{{ __("payment.labels.email") }}</label>
              <p class="payer-email">-</p>
            </div>
          </div>

          <!-- Payment Information Column -->
          <div class="col-md-6">
            <h5 class="mb-3">{{ __("payment.payment_information") }}</h5>

            <div class="mb-3">
              <label class="form-label fw-semibold">{{ __("payment.labels.type") }}</label>
              <p><span class="badge payment-type">-</span></p>
            </div>

            <div class="mb-3">
              <label class="form-label fw-semibold">{{ __("payment.labels.amount") }}</label>
              <p class="payment-amount">-</p>
            </div>

            <div class="mb-3">
              <label class="form-label fw-semibold">{{ __("payment.labels.status") }}</label>
              <p><span class="badge payment-status">-</span></p>
            </div>

            <div class="mb-3 paid-at-container" style="display: none;">
              <label class="form-label fw-semibold">{{ __("payment.labels.paid_at") }}</label>
              <p class="payment-paid-at">-</p>
            </div>

            <div class="mb-3 account-number-container" style="display: none;">
              <label class="form-label fw-semibold">{{ __("payment.labels.account_number") }}</label>
              <p class="payment-account-number">-</p>
            </div>

            <div class="mb-3 receipt-container" style="display: none;">
              <label class="form-label fw-semibold">{{ __("payment.labels.receipt") }}</label>
              <p><a href="#" class="btn btn-sm btn-primary payment-receipt" target="_blank">
                <i class="bx bx-download me-1"></i>{{ __("app.download") }}
              </a></p>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __("app.close") }}</button>
      </div>
    </div>
  </div>
</div>