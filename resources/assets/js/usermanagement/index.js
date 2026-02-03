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
      { data: 'action', orderable: false, searchable: false, width: '250px' },
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
        width: '320px',
        render: function (data) {
          if (!data) return '-';
          return data;
        }
      },
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
      },
      {
        data: 'updated_at',
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

  if ($('meta[name="error-message"]').length) {
    Swal.fire({
      icon: 'error',
      title: 'Gagal',
      text: $('meta[name="error-message"]').attr('content'),
      didOpen: () => {
        document.body.classList.add('modal-open');
      },
      didClose: () => {
        document.body.classList.remove('modal-open');
      }
    });
  }
});
