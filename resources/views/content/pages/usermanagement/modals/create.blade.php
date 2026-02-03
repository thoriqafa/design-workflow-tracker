<div class="modal fade" id="modalCreate" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">

      <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="modal-header">
          <h5 class="modal-title">Register User</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">

          <div class="mb-3">
            <label class="form-label">Nama</label>
            <input type="text" name="name" value="{{ old('name') }}"
              class="form-control @error('name') is-invalid @enderror" autofocus>
            @error('name')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3">
            <label class="form-label">Role</label>
            <select name="role" class="form-select selectpicker w-100 mb-3 @error('role') is-invalid @enderror"
              data-style="btn-default">
              <option value="">Pilih Role</option>
              <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
              <option value="supervisor" {{ old('role') == 'supervisor' ? 'selected' : '' }}>Supervisor</option>
              <option value="staff" {{ old('role') == 'staff' ? 'selected' : '' }}>Staff</option>
            </select>

            @error('role')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
            Batal
          </button>

          <button type="submit" class="btn btn-primary">
            Simpan
          </button>
        </div>

      </form>

    </div>
  </div>
</div>
