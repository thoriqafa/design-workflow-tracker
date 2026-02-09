@php
  use Illuminate\Support\Facades\Auth;
@endphp

@extends('layouts/layoutMaster')

@section('title', 'My Work Progress')

@section('page-style')
  @vite(['resources/assets/css/workprogress/index.css'])
@endsection

@section('vendor-script')
  @vite(['resources/assets/vendor/libs/jquery-repeater/jquery-repeater.js'])
@endsection

@section('page-script')
  @vite(['resources/assets/js/workprogress/index.js', 'resources/assets/js/workprogress/create-edit.js', 'resources/assets/js/workprogress/remarks.js', 'resources/assets/js/workprogress/approval-note.js'])
@endsection

@section('content')

  <div class="row">
    <div class="col-12">

      <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
          <h4 class="fw-bold mb-0">List Design Tasks</h4>
          <p class="text-muted mb-0">
            Daftar seluruh pekerjaan yang telah buat dalam sistem ini.
          </p>
        </div>
      </div>

      <div class="card">
        <div class="card-body">


          {{-- @can('design.upload') --}}
          <div class="row mb-4">

            <div class="card icon-card cursor-pointer text-center mb-6 mx-3 border shadow-none" data-bs-toggle="modal"
              data-bs-target="#modalCreateEdit">
              <div class="card-body py-5 px-0">
                <i class="bx bx-plus-circle fs-2 mb-1"></i>
                <p class="icon-name mb-0">
                  New <br />Task
                </p>
              </div>
            </div>

            <div class="card icon-card cursor-pointer text-center mb-6 mx-3 border shadow-none" id="btnRefresh">
              <div class="card-body py-5 px-0">
                <i class="bx bx-refresh fs-2 mb-1"></i>
                <p class="icon-name mb-0">
                  Refresh
                </p>
              </div>
            </div>
            {{-- @endcan --}}

            {{-- <div class="row mb-3">

            <div class="col-md-3">
              <label for="filter-tanggal" class="form-label">Tanggal</label>
              <input type="text" id="filter-tanggal" class="form-control">
            </div>

            <div class="col-md-3">
              <label for="filter-status" class="form-label">Status</label>
              <select id="filter-status" class="form-select">
                <option value="">Semua Status</option>
                <option value="0">Pending</option>
                <option value="1">Approved</option>
                <option value="2">Rejected</option>
              </select>
            </div> --}}

          </div>

          <div class="table-responsive">
            <table class="table table-bordered table-striped w-100" id="workProgressTable">
              <thead>
                <tr>
                  <th rowspan="2">#</th>
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

  @include('content.pages.workprogress.modals.create-edit')
  @include('content.pages.workprogress.modals.remarks')
  @include('content.pages.workprogress.modals.approval-note')

@endsection
