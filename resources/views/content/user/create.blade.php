<div class="modal fade" id="create-modal" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <h4 class="fw-bold py-1 mb-1">{{ __("user.modals.create") }}</h4>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
              <form class="form-horizontal" onsubmit="event.preventDefault()" action="#"
                  enctype="multipart/form-data" id="create-form">

                  <div class="mb-3">
                    <label for="name" class="form-label">{{ __("user.labels.name") }}</label>
                    <input type="text" class="form-control" name="name" placeholder="{{ __("user.placeholders.name") }}" autofocus>
                  </div>
                  <div class="mb-3">
                    <label for="email" class="form-label">{{ __("user.labels.email") }}</label>
                    <input type="text" class="form-control" name="email" placeholder="{{ __("user.placeholders.email") }}">
                  </div>
                  <div class="mb-3 form-password-toggle">
                    <label class="form-label" for="password">{{ __("user.labels.password") }}</label>
                    <div class="input-group input-group-merge">
                      <input type="password" class="form-control" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" />
                      <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                    </div>
                  </div>
                  <div class="mb-3 text-center" >
                      <button type="submit" id="create-submit" name="submit"
                          class="btn btn-primary">{{ __("app.create") }}</button>
                  </div>

              </form>
          </div>
      </div>
  </div>
</div>
