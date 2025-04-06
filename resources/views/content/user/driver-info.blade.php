<div class="modal fade" id="driver-info-modal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="fw-bold py-1 mb-1">{{ __('user.modals.info') }}</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <!-- User Information Column -->
                    <div class="col-md-6 border-end">
                        <h5 class="mb-3">{{ __('user.user_information') }}</h5>

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

                    <!-- Truck Information Column (Conditional) -->

                    <div class="col-md-6 truck-column"> <!-- Changed from truck-section -->
                        <div class="truck-section" style="display: none;">
                            <h5 class="mb-3">{{ __('user.truck.title') }}</h5>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">{{ __('user.truck.type') }}</label>
                                <p class="truck-type">-</p>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">{{ __('user.truck.serial_number') }}</label>
                                <p class="serial-number">-</p>
                            </div>

                            <div class="mb-3">
                                <label
                                    class="form-label fw-semibold">{{ __('user.truck.insurance_expiry_date') }}</label>
                                <p class="insurance-expiry-date">-</p>
                            </div>

                            <div class="mb-3">
                                <label
                                    class="form-label fw-semibold">{{ __('user.truck.next_inspection_date') }}</label>
                                <p class="next-inspection-date">-</p>
                            </div>

                            <div class="mb-3 affiliated-with-agency-container">
                                <label
                                    class="form-label fw-semibold">{{ __('user.truck.affiliated_with_agency') }}</label>
                                <p class="affiliated-with-agency">-</p>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">{{ __('user.truck.gray_card') }}</label>
                                <p><a href="#" class="btn btn-sm btn-primary gray-card-link" target="_blank">
                                        <i class="bx bx-download me-1"></i>{{ __('app.download') }}
                                    </a></p>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">{{ __('user.truck.driving_license') }}</label>
                                <p><a href="#" class="btn btn-sm btn-primary driving-license-link"
                                        target="_blank">
                                        <i class="bx bx-download me-1"></i>{{ __('app.download') }}
                                    </a></p>
                            </div>

                            <div class="mb-3">
                                <label
                                    class="form-label fw-semibold">{{ __('user.truck.insurance_certificate') }}</label>
                                <p><a href="#" class="btn btn-sm btn-primary insurance-certificate-link"
                                        target="_blank">
                                        <i class="bx bx-download me-1"></i>{{ __('app.download') }}
                                    </a></p>
                            </div>

                            <div class="mb-3">
                                <label
                                    class="form-label fw-semibold">{{ __('user.truck.inspection_certificate') }}</label>
                                <p><a href="#" class="btn btn-sm btn-primary inspection-certificate-link"
                                        target="_blank">
                                        <i class="bx bx-download me-1"></i>{{ __('app.download') }}
                                    </a></p>
                            </div>



                            <div class="mb-3 agency-document-container">
                                <label class="form-label fw-semibold">{{ __('user.truck.agency_document') }}</label>
                                <p><a href="#" class="btn btn-sm btn-primary agency-document-link"
                                        target="_blank">
                                        <i class="bx bx-download me-1"></i>{{ __('app.download') }}
                                    </a></p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('app.close') }}</button>
            </div>
        </div>
    </div>
</div>
