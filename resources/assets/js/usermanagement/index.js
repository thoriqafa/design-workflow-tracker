import $ from 'jquery';
import 'datatables.net-bs5';

window.$ = window.jQuery = $;

$(document).ready(function () {
  let userListTable = $('#userListTable').DataTable({
    processing: true,
    serverSide: true,
    responsive: false,
    autoWidth: false,
    ajax: {
      url: baseUrl + '/user-management/datatable'
    },

    columns: [
      { data: 'DT_RowIndex', orderable: false, searchable: false, width: '60px' },
      {
        data: 'name',
        width: '220px',
        render: function (data) {
          if (!data) return '-';
          return data;
        }
      },
      {
        data: 'role',
        width: '100px',
        render: function (data) {
          if (!data) return '-';
          return data;
        }
      },
      {
        data: 'created_at',
        width: '200px',
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
        data: 'updated_at',
        width: '200px',
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
      { data: 'action', orderable: false, searchable: false, width: '200px' }
    ],
    columnDefs: [
      {
        targets: [0, 1, 2, 3, 4, 5],
        className: 'text-center align-middle'
      }
    ]
  });

  if ($('meta[name="success-message"]').length) {
    Swal.fire({
      icon: 'success',
      title: 'Berhasil',
      text: $('meta[name="success-message"]').attr('content'),
      timer: 2000,
      showConfirmButton: false,
      didOpen: () => {
        document.body.classList.add('modal-open');
      },
      didClose: () => {
        document.body.classList.remove('modal-open');
      }
    });
  }

  // if ($('meta[name="error-message"]').length) {
  //   Swal.fire({
  //     icon: 'error',
  //     title: 'Gagal',
  //     text: $('meta[name="error-message"]').attr('content'),
  //     didOpen: () => {
  //       document.body.classList.add('modal-open');
  //     },
  //     didClose: () => {
  //       document.body.classList.remove('modal-open');
  //     }
  //   });
  // }

  // =================================================
  // button edit data
  // =================== start =======================
  $('#userListTable').on('click', '.btn-row-edit', function (e) {
    e.stopPropagation();

    const id = $(this).data('id');

    $.ajax({
      url: baseUrl + '/user-management/' + id,
      method: 'GET',
      success: function (res) {
        const modal = $('#modalEdit');
        const $roleSelect = modal.find('[name="role"]');

        modal.find('form').attr('action', baseUrl + '/user-management/' + res.id);
        modal.find('[name="name"]').val(res.name);

        $roleSelect.selectpicker('destroy');
        $roleSelect.val(res.role);
        $roleSelect.selectpicker();

        modal.modal('show');
      },
      error: function (xhr) {
        notify.error(xhr.responseJSON?.message || 'Error');
      }
    });
  });
  // =================== end =======================

  // =================================================
  // button reset password : default = bmi12345
  // =================== start =======================
  $('#userListTable').on('click', '.btn-row-reset-password', function (e) {
    e.stopPropagation();

    const id = $(this).data('id');

    Swal.fire({
      title: 'Reset Password?',
      html: `
            Password user akan direset menjadi:
            <br>
            <b>bmi12345</b>
        `,
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Ya, Reset',
      cancelButtonText: 'Batal',
      confirmButtonColor: '#d33',
      reverseButtons: true
    }).then(result => {
      if (result.isConfirmed) {
        $.ajax({
          url: baseUrl + '/user-management/' + id + '/reset-password',
          method: 'POST',
          data: {
            _token: $('meta[name="csrf-token"]').attr('content')
          },
          success: function (res) {
            $('#userListTable').DataTable().ajax.reload(null, false);

            Swal.fire({
              icon: 'success',
              title: 'Berhasil',
              text: res.message || 'Password berhasil direset',
              timer: 2000,
              showConfirmButton: false,
              didOpen: () => {
                document.body.classList.add('modal-open');
              },
              didClose: () => {
                document.body.classList.remove('modal-open');
              }
            });
          },
          error: function (xhr) {
            Swal.fire({
              icon: 'error',
              title: 'Gagal',
              text: xhr.responseJSON?.message || 'Terjadi kesalahan'
            });
          }
        });
      }
    });
  });
  // =================== end =======================

  if ($('meta[name="has-errors"]').length) {
    $('#modalCreate').modal('show'); // buka modal
  }

  // =================================================
  // button delete user
  // =================== start =======================
  $('#userListTable').on('click', '.btn-row-delete', function (e) {
    e.stopPropagation();

    const id = $(this).data('id');

    Swal.fire({
      title: 'Delete User?',
      html: `User akan dihapus permanen dari sistem.`,
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Ya, Hapus',
      cancelButtonText: 'Batal',
      confirmButtonColor: '#d33',
      reverseButtons: true
    }).then(result => {
      if (result.isConfirmed) {
        $.ajax({
          url: baseUrl + '/user-management/' + id,
          method: 'POST',
          data: {
            _method: 'DELETE',
            _token: $('meta[name="csrf-token"]').attr('content')
          },
          success: function (res) {
            Swal.fire({
              icon: 'success',
              title: 'Berhasil',
              text: res.message || 'User berhasil dihapus',
              timer: 2000,
              showConfirmButton: false,
              didOpen: () => {
                document.body.classList.add('modal-open');
              },
              didClose: () => {
                document.body.classList.remove('modal-open');
              }
            }).then(() => {
              location.reload(); // reload page di sini
            });
          },
          error: function (xhr) {
            Swal.fire({
              icon: 'error',
              title: 'Gagal',
              text: xhr.responseJSON?.message || 'Terjadi kesalahan'
            });
          }
        });
      }
    });
  });
  // =================== end =======================
});
