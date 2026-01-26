<div class="modal fade" id="modalApprovalNote" tabindex="-1" aria-hidden="true" data-bs-backdrop="static"
  data-bs-keyboard="false">

  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">

      <form id="form-approval-note" novalidate>
        @csrf

        <div class="modal-header">
          <h5 class="modal-title">Approval Note</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">

          <div class="card mb-4 shadow-sm">
            <div class="card-header border-bottom border-2">
              Approval Text
            </div>
            <div class="card-body border-2">

              <input type="text" id="header-id-for-approval" name="header_id" class="form-control" hidden />

              <div class="form-repeater mt-3">
                <div data-repeater-list="approval_text">
                  <div data-repeater-item>
                    <div class="row g-3 align-items-center mb-3">
                      <label class="col-md-2 col-form-label">Text</label>
                      <div class="col-md-8">
                        <input type="text" name="approval_text" class="form-control" />
                        <div class="invalid-feedback"></div>
                      </div>
                      <div class="col-md-2 text-end">
                        <button type="button" class="btn btn-outline-danger" data-repeater-delete>
                          <i class="bx bx-trash"></i>
                        </button>
                      </div>
                    </div>
                  </div>
                </div>

                <button type="button" class="btn btn-primary" data-repeater-create>
                  <i class="bx bx-plus me-1"></i>
                  Tambah Note
                </button>
              </div>

            </div>
          </div>

          <div class="card mb-4 shadow-sm">
            <div class="card-header border-bottom border-2">
              Approval Warna
            </div>
            <div class="card-body border-2">

              <div class="form-repeater mt-3">
                <div data-repeater-list="approval_color">
                  <div data-repeater-item>
                    <div class="row g-3 align-items-center mb-3">
                      <label class="col-md-2 col-form-label">Warna</label>
                      <div class="col-md-8">
                        <input type="text" name="approval_color" class="form-control" />
                        <div class="invalid-feedback"></div>
                      </div>
                      <div class="col-md-2 text-end">
                        <button type="button" class="btn btn-outline-danger" data-repeater-delete>
                          <i class="bx bx-trash"></i>
                        </button>
                      </div>
                    </div>
                  </div>
                </div>

                <button type="button" class="btn btn-primary" data-repeater-create>
                  <i class="bx bx-plus me-1"></i>
                  Tambah Note
                </button>
              </div>

            </div>
          </div>

        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Save</button>
        </div>

      </form>

    </div>
  </div>
</div>
