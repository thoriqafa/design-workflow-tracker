@php
  use Illuminate\Support\Facades\Auth;
@endphp

@extends('layouts/layoutMaster')

@section('title', 'List Users')

@section('vendor-style')
  @vite(['resources/assets/vendor/libs/bootstrap-select/bootstrap-select.scss'])
@endsection

@section('page-style')
  @vite(['resources/assets/css/usermanagement/index.css'])
@endsection

@section('vendor-script')
  @vite(['resources/assets/vendor/libs/bootstrap-select/bootstrap-select.js'])
@endsection

@section('page-script')
  @vite(['resources/assets/js/forms-selects.js', 'resources/assets/js/usermanagement/index.js'])
@endsection

@if (session('success'))
  <meta name="success-message" content="{{ session('success') }}">
@endif

@if ($errors->any())
  <meta name="error-message" content="Periksa kembali input yang Anda masukkan">
@endif

@section('content')

  <div class="row">
    <div class="col-12">

      <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
          <h4 class="fw-bold mb-0">List Users</h4>
          <p class="text-muted mb-0">
            Daftar seluruh user yang terdaftar untuk mengakses aplikasi.
          </p>
        </div>
      </div>

      <div class="card">
        <div class="card-body">
          <div class="row mb-4">

            <div class="card icon-card cursor-pointer text-center mb-6 mx-3 border shadow-none" data-bs-toggle="modal"
              data-bs-target="#modalCreate">

              <div class="card-body py-5 px-0">
                <i class="bx bx-plus-circle fs-2 mb-1"></i>
                <p class="icon-name mb-0">
                  New <br />User
                </p>
              </div>

            </div>

            <a href="{{ url()->current() }}"
              class="card icon-card cursor-pointer text-center mb-6 mx-3 border shadow-none">
              {{-- <div class="card icon-card cursor-pointer text-center mb-6 mx-3 border shadow-none"> --}}
              <div class="card-body py-5 px-0">
                <i class="bx bx-refresh fs-2 mb-1"></i>
                <p class="icon-name mb-0">
                  Refresh
                </p>
              </div>
              {{-- </div> --}}
            </a>

          </div>

          <div class="table-responsive">
            <table class="table table-bordered table-striped w-100" id="userListTable">
              <thead>
                <tr>
                  <th>#</th>
                  <th>No</th>
                  <th>Nama</th>
                  <th>Role</th>
                  <th>Tgl Dibuat</th>
                  <th>Tgl Diubah</th>
                </tr>
              </thead>
            </table>
          </div>

        </div>
      </div>

    </div>
  </div>
  </div>

  @include('content.pages.usermanagement.modals.create')
  @include('content.pages.usermanagement.modals.edit')

@endsection
