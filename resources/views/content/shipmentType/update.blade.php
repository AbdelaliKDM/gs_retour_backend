<div class="modal fade" id="update-modal" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="fw-bold py-1 mb-1">{{ __("{$model}.modals.update") }}</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" onsubmit="event.preventDefault()" action="#"
                    enctype="multipart/form-data" id="update-form">

                    <input type="hidden" id="id" name="id">

                    <div class="mb-3">
                        <label for="name" class="form-label">{{ __("{$model}.labels.name_ar") }}</label>
                        <input type="text" class="form-control" name="name_ar">
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">{{ __("{$model}.labels.name_en") }}</label>
                        <input type="text" class="form-control" name="name_en">
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">{{ __("{$model}.labels.name_fr") }}</label>
                        <input type="text" class="form-control" name="name_fr">
                    </div>

                    <div class="mb-3 text-center" >
                        <button type="submit" id="update-submit" name="submit"
                            class="btn btn-cyan">{{ __('app.update') }}</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
