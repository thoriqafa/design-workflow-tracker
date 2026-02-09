import $ from 'jquery';
import 'datatables.net-bs5';

import moment from 'moment';
window.moment = moment;

window.$ = window.jQuery = $;

function nowYmdHi() {
  const d = new Date();
  const pad = n => n.toString().padStart(2, '0');

  return (
    `${d.getFullYear()}-${pad(d.getMonth() + 1)}-${pad(d.getDate())} ` +
    `${pad(d.getHours())}:${pad(d.getMinutes())}:${pad(d.getSeconds())}`
  );
}

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

$(document).ready(function () {
  let workProgressTable = $('#workProgressTable').DataTable({
    processing: true,
    serverSide: true,
    responsive: false,
    autoWidth: false,
    ajax: {
      url: baseUrl + '/work-progress/datatable'
      // data: function (d) {
      //   d.status = $('#filter-status').val();
      //   d.tanggal = $('#filter-tanggal').val();
      // }
    },

    columns: [
      { data: 'action', orderable: false, searchable: false, width: '250px' },
      { data: 'DT_RowIndex', orderable: false, searchable: false, width: '60px' },
      { data: 'supplier', width: '220px' },
      { data: 'item', width: '320px' },
      { data: 'no_approval', width: '350px' },
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
        data: 'created_at',
        width: '115px',
        render: function (data) {
          if (!data) return '-';
          let d = new Date(data);
          return (
            d.getFullYear() +
            '-' +
            String(d.getMonth() + 1).padStart(2, '0') +
            '-' +
            String(d.getDate()).padStart(2, '0')
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
        data: 'created_at',
        width: '115px',
        render: function (data) {
          if (!data) return '-';
          let d = new Date(data);
          return (
            d.getFullYear() +
            '-' +
            String(d.getMonth() + 1).padStart(2, '0') +
            '-' +
            String(d.getDate()).padStart(2, '0')
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
      { data: 'remarks', width: '500px' },
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
        targets: [0, 1, 4, 5, 6, 7, 8, 9, 10, 12],
        className: 'text-center align-middle'
      }
    ]
  });

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

  $('#btnRefresh').on('click', function () {
    $('#workProgressTable').DataTable().ajax.reload(null, false);
  });

  $('#workProgressTable').on('click', '.btn-row-edit', function (e) {
    e.stopPropagation();

    const id = $(this).data('id');
    $.ajax({
      url: baseUrl + '/work-progress/' + id,
      method: 'GET',
      success: function (res) {
        const modal = $('#modalCreateEdit');

        modal.data('mode', 'edit');
        modal.find('.modal-title').text('Edit Task');

        modal.find('form').data('id', res.id);

        modal.find('[name="item"]').val(res.item);
        modal.find('[name="supplier"]').val(res.supplier);
        modal.find('[name="no_approval"]').val(res.no_approval);

        modal.data('emailDate', res.email_received_at);

        modal.modal('show');
      },
      error: function (xhr) {
        notify.error(xhr.responseJSON?.message || 'Error');
      }
    });
  });

  $('#workProgressTable').on('click', '.btn-row-finish', function (e) {
    e.stopPropagation();

    const id = $(this).data('id');
    const startTime = $(this).data('start-time');
    const endTime = nowYmdHi();

    const start = new Date(startTime);
    const end = new Date(endTime);

    const diffMs = end - start;

    const totalSeconds = Math.floor(diffMs / 1000);

    const hours = Math.floor(totalSeconds / 3600);
    const minutes = Math.floor((totalSeconds % 3600) / 60);
    const seconds = totalSeconds % 60;

    const duration =
      String(hours).padStart(2, '0') + ':' + String(minutes).padStart(2, '0') + ':' + String(seconds).padStart(2, '0');

    // console.log(startTime + ' - ' + endTime + ' - ' + duration);

    $.ajax({
      url: baseUrl + '/work-progress/' + id,
      method: 'POST',
      data: {
        _token: $('meta[name="csrf-token"]').attr('content'),
        end_time: endTime,
        duration: duration,
        status_work: 2
      },
      success: function (res) {
        workProgressTable.ajax.reload(null, false);

        notify.success('Pekerjaan selesai');
      },
      error: function (xhr) {
        notify.error(xhr.responseJSON?.message || 'Gagal memulai progress');
      }
    });
  });

  $('#workProgressTable').on('click', '.btn-row-start', function (e) {
    e.stopPropagation();

    const id = $(this).data('id');
    $.ajax({
      url: baseUrl + '/work-progress/' + id,
      method: 'POST',
      data: {
        _token: $('meta[name="csrf-token"]').attr('content'),
        start_time: nowYmdHi(),
        status_work: 1
      },
      success: function (res) {
        workProgressTable.ajax.reload(null, false);

        notify.success('Pekerjaan dimulai');
      },
      error: function (xhr) {
        notify.error(xhr.responseJSON?.message || 'Gagal memulai progress');
      }
    });
  });

  $('#workProgressTable').on('click', '.btn-row-remark', function (e) {
    e.stopPropagation();

    const id = $(this).data('id');
    $.ajax({
      url: baseUrl + '/work-progress/' + id,
      method: 'GET',
      success: function (res) {
        const modal = $('#modalRemarks');

        modal.find('form').data('id', res.id);

        modal.find('[name="remarks"]').val(res.remarks);

        modal.modal('show');
      },
      error: function (xhr) {
        notify.error(xhr.responseJSON?.message || 'Error');
      }
    });
  });

  $('#workProgressTable').on('click', '.btn-row-approval', function (e) {
    e.stopPropagation();

    // Ambil header id dari tombol
    var id = $(this).data('id');

    const modal = $('#modalApprovalNote');
    const form = modal.find('form');

    form.find('#header-id-for-approval').val(id);

    const repeaterTextList = form.find('[data-repeater-list="approval_text"]');
    const repeaterColorList = form.find('[data-repeater-list="approval_color"]');

    repeaterTextList.find('[data-repeater-item]').remove();
    repeaterColorList.find('[data-repeater-item]').remove();

    $.ajax({
      url: baseUrl + '/work-progress/approval/get/' + id,
      method: 'GET',
      success: function (res) {
        // form.data('header_id', id);

        const texts = res.data.approval_text || [];
        const colors = res.data.approval_color || [];

        console.log(texts);
        console.log(colors);

        texts.forEach((text, index) => {
          repeaterTextList.closest('.form-repeater').find('[data-repeater-create]').trigger('click');

          repeaterTextList
            .find('[data-repeater-item]')
            .last()
            .find('input[name="approval_text[' + index + '][approval_text]"]')
            .val(text);
        });

        colors.forEach((color, index) => {
          repeaterColorList.closest('.form-repeater').find('[data-repeater-create]').trigger('click');

          repeaterColorList
            .find('[data-repeater-item]')
            .last()
            .find('input[name="approval_color[' + index + '][approval_color]"]')
            .val(color);
        });

        modal.modal('show');
      },
      error: function (xhr) {
        notify.error(xhr.responseJSON?.message || 'Error mengambil data approval');
      }
    });
  });
});
