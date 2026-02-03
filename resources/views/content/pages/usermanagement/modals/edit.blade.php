<div class="modal fade" id="modalEdit" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">

      <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="modal-header">
          <h5 class="modal-title">Edit User</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">

          <div class="mb-3">
            <label class="form-label">Nama</label>
            <input type="text" name="name" value="{{ old('name') }}"
              class="form-control @error('name') is-invalid @enderror" required autofocus>

            @error('name')
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
