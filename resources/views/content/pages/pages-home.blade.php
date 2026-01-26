@php
  $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Dashboard')

@section('content')
  <div class="container-xxl py-4">

    {{-- Welcome Section --}}
    <div class="row mb-4">
      <div class="col-12 text-center">
        <h2 class="fw-bold">Welcome back, {{ auth()->user()->name }}!</h2>
        <p class="text-muted">
          You are logged in as <strong>{{ ucfirst(auth()->user()->role) }}</strong>.
          Here’s a snapshot of your current tasks and team progress.
        </p>
      </div>
    </div>

    {{-- Quick Action Buttons --}}
    <div class="row mb-5 justify-content-center">
      @if (auth()->user()->role === 'admin')
        <div class="col-auto">
          <a href="{{ route('workprogress.index') }}" class="btn btn-primary shadow-sm">
            <i class="mdi mdi-view-dashboard-outline me-1"></i> Admin Dashboard
          </a>
        </div>
      @endif

      <div class="col-auto">
        <a href="{{ route('workmonitoring.index') }}" class="btn btn-success shadow-sm">
          <i class="mdi mdi-clipboard-text-outline me-1"></i> Work Monitoring
        </a>
      </div>

      @if (auth()->user()->role === 'staff')
        <div class="col-auto">
          <a href="{{ route('workprogress.index') }}" class="btn btn-info shadow-sm">
            <i class="mdi mdi-plus-box-outline me-1"></i> Start Your Work
          </a>
        </div>
      @endif
    </div>

    {{-- Stats Cards --}}
    <div class="row g-3">

      <div class="col-lg-3 col-sm-6">
        <div class="card card-border-shadow-info h-100">
          <div class="card-body">
            <div class="d-flex align-items-center mb-2">
              <div class="avatar me-4">
                <span class="avatar-initial rounded bg-label-info"><i
                    class="icon-base bx bx-time-five icon-lg"></i></span>
              </div>
              <h4 class="mb-0">{{ $taskCounts['all'] ?? 0 }}</h4>
            </div>
            <p class="mb-2">Pending Tasks</p>
            <p class="mb-0">
              {{-- <span class="text-heading fw-medium me-2">+18.2%</span> --}}
              {{-- <span class="text-body-secondary">than last week</span> --}}
            </p>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-sm-6">
        <div class="card card-border-shadow-warning h-100">
          <div class="card-body">
            <div class="d-flex align-items-center mb-2">
              <div class="avatar me-4">
                <span class="avatar-initial rounded bg-label-warning"><i class="icon-base bx bx-sync icon-lg"></i></span>
              </div>
              <h4 class="mb-0">{{ $taskCounts[1] ?? 0 }}</h4>
            </div>
            <p class="mb-2">In Progress Tasks</p>
            <p class="mb-0">
              {{-- <span class="text-heading fw-medium me-2">-8.7%</span> --}}
              {{-- <span class="text-body-secondary">than last week</span> --}}
            </p>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-sm-6">
        <div class="card card-border-shadow-danger h-100">
          <div class="card-body">
            <div class="d-flex align-items-center mb-2">
              <div class="avatar me-4">
                <span class="avatar-initial rounded bg-label-danger"><i
                    class="icon-base bx bx-check-circle icon-lg"></i></span>
              </div>
              <h4 class="mb-0">{{ $taskCounts[2] ?? 0 }}</h4>
            </div>
            <p class="mb-2">Finished Tasks</p>
            <p class="mb-0">
              {{-- <span class="text-heading fw-medium me-2">+4.3%</span> --}}
              {{-- <span class="text-body-secondary">than last week</span> --}}
            </p>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-sm-6">
        <div class="card card-border-shadow-info h-100">
          <div class="card-body">
            <div class="d-flex align-items-center mb-2">
              <div class="avatar me-4">
                <span class="avatar-initial rounded bg-label-info"><i
                    class="icon-base bx bx-list-check icon-lg"></i></span>
              </div>
              <h4 class="mb-0">{{ $taskCounts['all'] ?? 0 }}</h4>
            </div>
            <p class="mb-2">Total Tasks</p>
            <p class="mb-0">
              {{-- <span class="text-heading fw-medium me-2">-2.5%</span> --}}
              {{-- <span class="text-body-secondary">than last week</span> --}}
            </p>
          </div>
        </div>
      </div>
    </div>

  </div>

@endsection
