@extends('layouts/layoutMaster')

@section('title', 'Profile')

@section('content')
  <div class="container-xxl py-4">

    <div class="row g-3">

      {{-- Update Profile --}}
      <div class="col-12">
        <div class="card shadow-sm">
          <div class="card-header">
            <h5 class="mb-0">Update Profile Information</h5>
          </div>
          <div class="card-body">
            @include('profile.partials.update-profile-information-form')
          </div>
        </div>
      </div>

      {{-- Update Password --}}
      <div class="col-12">
        <div class="card shadow-sm mt-3">
          <div class="card-header">
            <h5 class="mb-0">Update Password</h5>
          </div>
          <div class="card-body">
            @include('profile.partials.update-password-form')
          </div>
        </div>
      </div>

      {{-- Delete Account --}}
      {{-- <div class="col-12">
        <div class="card shadow-sm mt-3">
          <div class="card-header">
            <h5 class="mb-0">Delete Account</h5>
          </div>
          <div class="card-body">
            @include('profile.partials.delete-user-form')
          </div>
        </div>
      </div> --}}

    </div>

  </div>
@endsection
