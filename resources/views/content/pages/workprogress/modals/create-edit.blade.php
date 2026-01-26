  <div class="modal fade" id="modalCreateEdit" tabindex="-1" aria-hidden="true" data-bs-backdrop="static"
    data-bs-keyboard="false">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">

        <form id="form-create-task" novalidate>
          @csrf

          <div class="modal-header">
            <h5 class="modal-title">New Task</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>

          <div class="modal-body">
            <div class="row mb-3 align-items-center">
              <label class="col-sm-3 col-form-label">Nama Desain</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" name="item" required>
                <div class="invalid-feedback"></div>
              </div>
            </div>

            <div class="row mb-3 align-items-center">
              <label class="col-sm-3 col-form-label">Supplier</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" name="supplier" required>
                <div class="invalid-feedback"></div>
              </div>
            </div>

            <div class="row mb-3 align-items-center">
              <label class="col-sm-3 col-form-label">No Approval Design</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" name="no_approval" required>
                <div class="invalid-feedback"></div>
              </div>
            </div>

            <div class="row mb-3 align-items-center">
              <label class="col-sm-3 col-form-label">Tgl Email Masuk</label>
              <div class="col-sm-9">
                <input type="text" id="flatpickr-datetime" name="email_received_at" class="form-control">
                <div class="invalid-feedback"></div>
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
