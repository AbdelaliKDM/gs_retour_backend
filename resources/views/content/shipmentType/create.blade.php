<div class="modal fade" id="create-modal" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="fw-bold py-1 mb-1">{{ __("shipmentType.modals.create") }}</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" onsubmit="event.preventDefault()" action="#"
                    enctype="multipart/form-data" id="create-form">

                    <div class="mb-3">
                        <label for="name" class="form-label">{{ __("shipmentType.labels.name_ar") }}</label>
                        <input type="text" class="form-control" name="name_ar"
                            placeholder="{{ __("shipmentType.placeholders.name_ar") }}" autofocus>
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">{{ __("shipmentType.labels.name_en") }}</label>
                        <input type="text" class="form-control" name="name_en"
                            placeholder="{{ __("shipmentType.placeholders.name_en") }}" autofocus>
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">{{ __("shipmentType.labels.name_fr") }}</label>
                        <input type="text" class="form-control" name="name_fr"
                            placeholder="{{ __("shipmentType.placeholders.name_fr") }}" autofocus>
                    </div>

                    <div class="mb-3 text-center" >
                        <button type="submit" id="create-submit" name="submit"
                            class="btn btn-primary">{{ __('app.create') }}</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
