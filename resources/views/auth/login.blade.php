@php
  $customizerHidden = 'customizer-hide';
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Login - Pages')

@section('vendor-style')
  @vite(['resources/assets/vendor/libs/@form-validation/form-validation.scss'])
@endsection

@section('page-style')
  @vite(['resources/assets/vendor/scss/pages/page-auth.scss'])
@endsection

@section('vendor-script')
  @vite(['resources/assets/vendor/libs/@form-validation/popular.js', 'resources/assets/vendor/libs/@form-validation/bootstrap5.js', 'resources/assets/vendor/libs/@form-validation/auto-focus.js'])
@endsection

@section('page-script')
  @vite(['resources/assets/js/pages-auth.js'])
@endsection

@section('content')
  <div class="container-xxl">
    <div class="authentication-wrapper authentication-basic container-p-y">
      <div class="authentication-inner">
        <!-- Login -->
        <div class="card">
          <div class="card-body">
            <!-- Logo -->
            <div class="app-brand justify-content-center">
              {{-- <a href="{{ url('/') }}" class="app-brand-link gap-2"> --}}
              {{-- <span class="app-brand-logo demo">@include('_partials.macros')</span> --}}
              <span class="app-brand-text demo text-heading fw-bold">{{ config('variables.templateName') }}</span>
              {{-- </a> --}}
            </div>
            <!-- /Logo -->
            <h4 class="mb-1">Welcome to {{ config('variables.templateName') }}! 👋</h4>
            <p class="mb-6">Welcome back. Sign in to continue managing your workflow.</p>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
              @csrf

              <!-- Email Address -->
              <div>
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')"
                  required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
              </div>

              <!-- Password -->
              <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" />

                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                  autocomplete="current-password" />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
              </div>

              <div class="flex items-center justify-end mt-4">

                <x-primary-button class="ms-3">
                  {{ __('Log in') }}
                </x-primary-button>
              </div>
            </form>
          </div>
        </div>
        <!-- /Login -->
      </div>
    </div>
  </div>
@endsection
