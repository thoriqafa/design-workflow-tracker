@php
  use Illuminate\Support\Facades\Auth;
@endphp

@extends('layouts/layoutMaster')

@section('title', 'My Work Progress')

@section('vendor-style')
  @vite(['resources/assets/vendor/libs/bootstrap-select/bootstrap-select.scss', 'resources/assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.scss'])
@endsection

@section('page-style')
  @vite(['resources/assets/css/workmonitoring/index.css'])
@endsection

@section('vendor-script')
  @vite(['resources/assets/vendor/libs/moment/moment.js', 'resources/assets/vendor/libs/bootstrap-select/bootstrap-select.js', 'resources/assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.js'])
@endsection

@section('page-script')
  @vite(['resources/assets/js/workmonitoring/index.js'])
@endsection

@section('content')

  <div class="row">
    <div class="col-12">

      <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
          <h4 class="fw-bold mb-0">List Monitoring Works</h4>
          <p class="text-muted mb-0">
            Daftar monitoring pekerjaan yang telah buat dalam sistem ini.
          </p>
        </div>
      </div>

      <div class="card">
        <div class="card-body">


          {{-- @can('design.upload') --}}
          <div class="row mb-4">

            @if (auth()->user()->role === 'supervisor')
              <div class="card icon-card cursor-pointer text-center mb-6 mx-3 border shadow-none" id="btnExport">
                <div class="card-body py-5 px-0">
                  <i class="bx bx-export fs-2 mb-1"></i>
                  <p class="icon-name mb-0">
                    Export to Excel
                  </p>
                </div>
              </div>
            @endif

            <div class="card icon-card cursor-pointer text-center mb-6 mx-3 border shadow-none">
              <div class="card-body py-5 px-0">
                <i class="bx bx-refresh fs-2 mb-1"></i>
                <p class="icon-name mb-0">
                  Refresh
                </p>
              </div>
            </div>


            {{-- @endcan --}}

            {{-- FILTER --}}
            <div class="row mb-3">
              <div class="col-md-3">
                <label for="bs-rangepicker-basic" class="form-label">Basic</label>
                <input type="text" id="bs-rangepicker-basic" class="form-control" />
              </div>

              <div class="col-md-2">
                <label class="form-label">Status</label>
                <select id="status-work" class="selectpicker w-100" data-style="btn-default">
                  <option value="">All</option>
                  <option value="0">Not Started</option>
                  <option value="1">In Progress</option>
                  <option value="2">Finished</option>
                </select>
              </div>

              <div class="col-md-3 d-flex align-items-end">
                <button type="button" class="btn btn-primary" id="btnFilter">
                  Filter
                </button>
              </div>

            </div>

            <div class="table-responsive">
              <table class="table table-bordered table-striped w-100" id="workMonitoringTable">
                <thead>
                  <tr>
                    <th rowspan="2">No</th>
                    <th rowspan="2">Supplier</th>
                    <th rowspan="2">Jenis Item</th>
                    <th rowspan="2">No Approval Design</th>
                    <th rowspan="2">Tgl Email Masuk</th>
                    <th rowspan="2">Status</th>
                    <th rowspan="2">Mulai</th>
                    <th rowspan="2">Selesai</th>
                    <th rowspan="2">Durasi (jam.menit)</th>
                    <th colspan="2">Approval Teks</th>
                    <th colspan="2">Approval Warna</th>
                    <th rowspan="2">Remark</th>
                    <th rowspan="2">Creator</th>
                    <th rowspan="2">Tgl Dibuat</th>
                  </tr>
                  <tr>
                    <th>Tgl Cek</th>
                    <th>Ket</th>
                    <th>Tgl Cek</th>
                    <th>Ket</th>
                  </tr>
                </thead>
              </table>
            </div>

          </div>
        </div>

      </div>
    </div>
  </div>

@endsection
