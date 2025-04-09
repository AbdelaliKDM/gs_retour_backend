<div class="modal fade" id="invoice-info-modal" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header bg-light">
        <h5 class="modal-title fw-bold">{{ __("payment.modals.invoice_info") }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-0">
        <div class="row g-0">
          <!-- Payer Information Column -->
          <div class="col-md-5 border-end">
            <div class="p-3">
              <div class="d-flex align-items-center mb-3">
                <img src="https://placehold.co/100?text=User" alt="User" class="payer-image rounded-circle me-3" width="60" height="60">
                <div>
                  <h6 class="mb-1 fw-semibold">{{ __("payment.payer_information") }}</h6>
                  <p class="payer-name mb-0 fs-5">-</p>
                </div>
              </div>

              <div class="list-group list-group-flush">
                <div class="list-group-item px-0 py-2 d-flex justify-content-between border-0">
                  <span class="text-muted">{{ __("payment.labels.phone") }}:</span>
                  <span class="payer-phone fw-semibold">-</span>
                </div>
                <div class="list-group-item px-0 py-2 d-flex justify-content-between border-0">
                  <span class="text-muted">{{ __("payment.labels.email") }}:</span>
                  <span class="payer-email fw-semibold">-</span>
                </div>
              </div>

              <!-- Invoice Information Section -->
              <div class="mt-3 pt-3 border-top">
                <h6 class="mb-2 fw-semibold">{{ __("payment.invoice_information") }}</h6>
                <div class="list-group list-group-flush">
                  <div class="list-group-item px-0 py-2 d-flex justify-content-between border-0">
                    <span class="text-muted">{{ __("payment.labels.total_amount") }}:</span>
                    <span class="invoice-total-amount fw-semibold">-</span>
                  </div>
                  <div class="list-group-item px-0 py-2 d-flex justify-content-between border-0">
                    <span class="text-muted">{{ __("payment.labels.tax_amount") }}:</span>
                    <span class="invoice-tax-amount fw-semibold">-</span>
                  </div>
                  <div class="list-group-item px-0 py-2 d-flex justify-content-between border-0">
                    <span class="text-muted">{{ __("payment.labels.month") }}:</span>
                    <span class="invoice-month fw-semibold">-</span>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Payment Information Column -->
          <div class="col-md-7">
            <div class="p-3">
              <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="mb-0 fw-semibold">{{ __("payment.payment_information") }}</h6>
                <span class="badge payment-status">-</span>
              </div>

              <div class="card bg-light mb-3">
                <div class="card-body py-2">
                  <div class="d-flex justify-content-between align-items-center">
                    <span class="text-muted">{{ __("payment.labels.amount") }}</span>
                    <span class="payment-amount fs-4 fw-bold">-</span>
                  </div>
                </div>
              </div>

              <div class="list-group list-group-flush">
                <div class="list-group-item px-0 py-2 d-flex justify-content-between border-0">
                  <span class="text-muted">{{ __("payment.labels.type") }}:</span>
                  <span class="badge payment-type">-</span>
                </div>

                <div class="list-group-item px-0 py-2 d-flex justify-content-between border-0">
                  <span class="text-muted">{{ __("payment.labels.payment_method") }}:</span>
                  <span class="badge payment-method">-</span>
                </div>

                <div class="list-group-item px-0 py-2 d-flex justify-content-between border-0 paid-at-container" style="display: none;">
                  <span class="text-muted">{{ __("payment.labels.paid_at") }}:</span>
                  <span class="payment-paid-at fw-semibold">-</span>
                </div>

                <div class="list-group-item px-0 py-2 d-flex justify-content-between border-0 account-number-container" style="display: none;">
                  <span class="text-muted">{{ __("payment.labels.account_number") }}:</span>
                  <span class="payment-account-number fw-semibold">-</span>
                </div>

                <div class="list-group-item px-0 py-2 d-flex justify-content-between border-0 account-number-container" style="display: none;">
                  {{-- <span class="text-muted">{{ __("payment.labels.receipt") }}:</span> --}}
                  <div class="receipt-container">
                    <a class="payment-receipt btn btn-sm">
                        <i class="bx bx-receipt me-1"></i><span>{{ __('payment.labels.receipt') }}</span>
                    </a>
                </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer bg-light py-2">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __("app.close") }}</button>
      </div>
    </div>
  </div>
</div>
