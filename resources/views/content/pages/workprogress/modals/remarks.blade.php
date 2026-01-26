  <div class="modal fade" id="modalRemarks" tabindex="-1" aria-hidden="true" data-bs-backdrop="static"
    data-bs-keyboard="false">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">

        <form id="form-create-remarks" novalidate>
          @csrf

          <div class="modal-header">
            <h5 class="modal-title">Remarks</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>

          <div class="modal-body">
            <div class="row mb-3 align-items-center">
              <label class="col-sm-2 col-form-label">Remarks</label>
              <div class="col-sm-10">
                <textarea id="remarks-note" name="remarks" class="form-control" rows="3"></textarea>
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
