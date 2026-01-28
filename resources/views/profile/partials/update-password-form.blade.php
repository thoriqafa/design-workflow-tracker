<form method="POST" action="{{ route('password.update') }}">
  @csrf
  @method('PUT')

  {{-- Feedback sukses --}}
  @if (session('status') === 'password-updated')
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      Password berhasil diubah
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

  {{-- Feedback error --}}
  @if ($errors->updatePassword->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <strong>Terjadi kesalahan:</strong>
      <ul class="mb-0">
        @foreach ($errors->updatePassword->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

  {{-- Password Lama --}}
  <div class="mb-3">
    <label for="current_password" class="form-label">Password Lama</label>
    <input type="password" class="form-control @error('current_password') is-invalid @enderror" id="current_password"
      name="current_password" required>
    @error('current_password')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>

  {{-- Password Baru --}}
  <div class="mb-3">
    <label for="password" class="form-label">Password Baru</label>
    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password"
      required>
    @error('password')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
    <div class="form-text">
      Password harus minimal 8 karakter.
    </div>
  </div>

  {{-- Konfirmasi Password --}}
  <div class="mb-3">
    <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
  </div>

  {{-- Checkbox Show Password --}}
  <div class="form-check mb-3">
    <input class="form-check-input" type="checkbox" value="" id="showPasswordCheck">
    <label class="form-check-label" for="showPasswordCheck">
      Tampilkan Password
    </label>
  </div>

  <button type="submit" class="btn btn-primary">Simpan</button>
</form>

{{-- Script untuk checkbox show/hide password --}}
<script>
  const showPasswordCheck = document.getElementById('showPasswordCheck');
  showPasswordCheck.addEventListener('change', function() {
    const type = this.checked ? 'text' : 'password';
    document.getElementById('current_password').type = type;
    document.getElementById('password').type = type;
    document.getElementById('password_confirmation').type = type;
  });
</script>
