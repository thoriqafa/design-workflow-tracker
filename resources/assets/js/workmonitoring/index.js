import $ from 'jquery';
import 'datatables.net-bs5';

import moment from 'moment';
window.moment = moment;

window.$ = window.jQuery = $;

// =================================================
// function untuk pisahkan || ke poin poin
// =================== start =======================
function splitToBullet(data) {
  if (!data) return '-';

  let items = data
    .split('||')
    .map(v => v.trim())
    .filter(v => v !== '');

  if (!items.length) return '-';

  return `
    <ul class="mb-0 ps-3">
      ${items.map(v => `<li>• ${v}</li>`).join('')}
    </ul>
  `;
}
// =================== end =======================

// =================================================
// function untuk formatting data (YYYY-MM-DD)
// =================== start =======================
function formatDateTime(d) {
  return d.getFullYear() + '-' + String(d.getMonth() + 1).padStart(2, '0') + '-' + String(d.getDate()).padStart(2, '0');
}
// =================== end =======================

$(document).ready(function () {
  let tglAwal = formatDateTime(new Date());
  let tglAkhir = formatDateTime(new Date());
  let statusWork = '';

  let workMonitoringTable = $('#workMonitoringTable').DataTable({
    processing: true,
    serverSide: true,
    responsive: false,
    autoWidth: false,
    ajax: {
      url: baseUrl + '/work-monitoring/datatable',
      data: function (d) {
        d.statusWork = statusWork;
        d.tanggalAwal = tglAwal;
        d.tanggalAkhir = tglAkhir;
      }
    },

    columns: [
      { data: 'DT_RowIndex', orderable: false, searchable: false, width: '60px' },
      {
        data: 'supplier',
        width: '220px',
        render: function (data) {
          if (!data) return '-';
          return data;
        }
      },
      {
        data: 'item',
        width: '320px',
        render: function (data) {
          if (!data) return '-';
          return data;
        }
      },
      {
        data: 'no_approval',
        width: '350px',
        render: function (data) {
          if (!data) return '-';
          return data;
        }
      },
      {
        data: 'email_received_at',
        width: '250px',
        render: function (data) {
          if (!data) return '-';
          let d = new Date(data);
          return (
            d.getFullYear() +
            '-' +
            String(d.getMonth() + 1).padStart(2, '0') +
            '-' +
            String(d.getDate()).padStart(2, '0') +
            ' ' +
            String(d.getHours()).padStart(2, '0') +
            ':' +
            String(d.getMinutes()).padStart(2, '0') +
            ':' +
            String(d.getSeconds()).padStart(2, '0')
          );
        }
      },
      { data: 'status', width: '120px' },
      {
        data: 'start_time',
        width: '250px',
        render: function (data) {
          if (!data) return '-';
          let d = new Date(data);
          return (
            d.getFullYear() +
            '-' +
            String(d.getMonth() + 1).padStart(2, '0') +
            '-' +
            String(d.getDate()).padStart(2, '0') +
            ' ' +
            String(d.getHours()).padStart(2, '0') +
            ':' +
            String(d.getMinutes()).padStart(2, '0') +
            ':' +
            String(d.getSeconds()).padStart(2, '0')
          );
        }
      },
      {
        data: 'end_time',
        width: '250px',
        render: function (data) {
          if (!data) return '-';
          let d = new Date(data);
          return (
            d.getFullYear() +
            '-' +
            String(d.getMonth() + 1).padStart(2, '0') +
            '-' +
            String(d.getDate()).padStart(2, '0') +
            ' ' +
            String(d.getHours()).padStart(2, '0') +
            ':' +
            String(d.getMinutes()).padStart(2, '0') +
            ':' +
            String(d.getSeconds()).padStart(2, '0')
          );
        }
      },
      { data: 'duration', width: '170px' },
      {
        data: 'text_created_at',
        width: '250px',
        render: function (data) {
          if (!data) return '-';
          let d = new Date(data);
          return (
            d.getFullYear() +
            '-' +
            String(d.getMonth() + 1).padStart(2, '0') +
            '-' +
            String(d.getDate()).padStart(2, '0') +
            ' ' +
            String(d.getHours()).padStart(2, '0') +
            ':' +
            String(d.getMinutes()).padStart(2, '0') +
            ':' +
            String(d.getSeconds()).padStart(2, '0')
          );
        }
      },
      {
        data: 'text_review',
        width: '500px',
        render: function (data, type) {
          if (type !== 'display') return data;
          return splitToBullet(data);
        }
      },
      {
        data: 'color_created_at',
        width: '250px',
        render: function (data) {
          if (!data) return '-';
          let d = new Date(data);
          return (
            d.getFullYear() +
            '-' +
            String(d.getMonth() + 1).padStart(2, '0') +
            '-' +
            String(d.getDate()).padStart(2, '0') +
            ' ' +
            String(d.getHours()).padStart(2, '0') +
            ':' +
            String(d.getMinutes()).padStart(2, '0') +
            ':' +
            String(d.getSeconds()).padStart(2, '0')
          );
        }
      },
      {
        data: 'color_review',
        width: '500px',
        render: function (data, type) {
          if (type !== 'display') return data;
          return splitToBullet(data);
        }
      },
      {
        data: 'remarks',
        width: '500px',
        render: function (data) {
          if (!data) return '-';
          return data;
        }
      },
      { data: 'creator_name', width: '160px' },
      {
        data: 'created_at',
        width: '250px',
        render: function (data) {
          if (!data) return '-';
          let d = new Date(data);
          return (
            d.getFullYear() +
            '-' +
            String(d.getMonth() + 1).padStart(2, '0') +
            '-' +
            String(d.getDate()).padStart(2, '0') +
            ' ' +
            String(d.getHours()).padStart(2, '0') +
            ':' +
            String(d.getMinutes()).padStart(2, '0') +
            ':' +
            String(d.getSeconds()).padStart(2, '0')
          );
        }
      }
    ],
    columnDefs: [
      {
        targets: [0, 3, 4, 5, 6, 7, 8, 9, 11, 14, 15],
        className: 'text-center align-middle'
      }
    ]
  });

  // =================================================
  // untuk filter data
  // =================== start =======================
  $('#btnExport').on('click', function () {
    let dt = $('#workMonitoringTable').DataTable();
    let params = new URLSearchParams();

    params.append('statusWork', statusWork);
    params.append('tanggalAwal', tglAwal);
    params.append('tanggalAkhir', tglAkhir);

    // Ambil search, start, length dari DataTables
    params.append('search', dt.search());
    params.append('start', dt.page.info().start);
    params.append('length', dt.page.info().length);

    // Arahkan ke route export yang benar
    window.location.href = baseUrl + '/work-monitoring/export-excel?' + params.toString();
  });
  // =================== end =======================

  // $('#filter-status').change(function () {
  //   table.ajax.reload();
  // });

  // $('#filter-tanggal').daterangepicker({
  //   autoUpdateInput: false,
  //   opens: 'left',
  //   locale: {
  //     format: 'YYYY-MM-DD',
  //     separator: ' to ',
  //     applyLabel: 'Apply',
  //     cancelLabel: 'Cancel'
  //   }
  // });

  // =================================================
  // untuk filter data
  // =================== start =======================
  // $('#filter-tanggal').on('apply.daterangepicker', function (ev, picker) {
  //   $(this).val(picker.startDate.format('YYYY-MM-DD') + ' to ' + picker.endDate.format('YYYY-MM-DD'));
  //   table.ajax.reload();
  // });

  // $('#filter-tanggal').on('cancel.daterangepicker', function () {
  //   $(this).val('');
  //   table.ajax.reload();
  // });

  // =================================================
  // picker filter tanggal
  // =================== start =======================
  var bsRangePickerBasic = $('#bs-rangepicker-basic');
  if (bsRangePickerBasic.length) {
    bsRangePickerBasic.daterangepicker({
      opens: isRtl ? 'left' : 'right'
    });
  }
  // =================== end =======================
  $('#bs-rangepicker-basic').on('apply.daterangepicker', function (ev, picker) {
    tglAwal = formatDateTime(picker.startDate.toDate());
    tglAkhir = formatDateTime(picker.endDate.toDate());

    console.log('Saved range:', tglAwal, tglAkhir);
  });

  $('#status-work').on('change', function () {
    statusWork = $(this).val();
  });

  $('#btnFilter').on('click', function () {
    if (!tglAwal || !tglAkhir) {
      alert('Silakan pilih range tanggal terlebih dahulu');
      return;
    }

    // console.log('Saved range :', tglAwal, tglAkhir);
    // console.log('Saved status:', statusWork);

    workMonitoringTable.ajax.reload();
  });
});
