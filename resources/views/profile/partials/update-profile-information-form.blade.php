{{-- Form resend verification --}}
<form id="send-verification" method="post" action="{{ route('verification.send') }}">
  @csrf
</form>

{{-- Update profile form --}}
<form method="post" action="{{ route('profile.update') }}">
  @csrf
  @method('patch')

  @if (session('status') === 'profile-updated')
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      Nama berhasil diubah
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

  {{-- Name --}}
  <div class="mb-3">
    <label for="name" class="form-label">Nama</label>
    <input id="name" name="name" type="text" class="form-control @error('name') is-invalid @enderror"
      value="{{ old('name', $user->name) }}" required autofocus>
    @error('name')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>

  {{-- Email --}}
  <div class="mb-3" hidden>
    <label for="email" class="form-label">Email</label>
    <input id="email" name="email" type="email" class="form-control @error('email') is-invalid @enderror"
      value="{{ old('email', $user->email) }}" required>
    @error('email')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror

    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
      <div class="mt-2">
        <p class="text-muted small">
          Your email address is unverified.
          <button form="send-verification" class="btn btn-link btn-sm p-0">
            Click here to re-send the verification email
          </button>
        </p>

        @if (session('status') === 'verification-link-sent')
          <div class="alert alert-success mt-2">
            A new verification link has been sent to your email address.
          </div>
        @endif
      </div>
    @endif
  </div>

  {{-- Submit --}}
  <div class="d-flex align-items-center gap-2">
    <button type="submit" class="btn btn-primary">Simpan</button>
  </div>
</form>
