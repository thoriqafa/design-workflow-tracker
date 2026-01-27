'use strict';

$(document).ready(function () {
  if ($('.form-repeater').length) {
    $('.form-repeater').repeater({
      initEmpty: false,

      show: function () {
        $(this).slideDown();
      }

      // hide: function (deleteElement) {
      //   if (confirm('Hapus approval note ini?')) {
      //     $(this).slideUp(deleteElement);
      //   }
      // }
    });
  }

  $('#form-approval-note').on('submit', function (e) {
    e.preventDefault();

    var form = $(this);
    var formData = form.serialize();

    $.ajax({
      url: baseUrl + '/work-progress/approval/store',
      method: 'POST',
      data: formData,
      success: function (response) {
        if (response.status === 'success') {
          Swal.fire('Sukses', response.message, 'success');
          $('#modalApprovalNote').modal('hide');
          form[0].reset();
        } else {
          Swal.fire('Error', response.message, 'error');
        }
      },
      error: function (xhr) {
        var errors = xhr.responseJSON?.errors;
        if (errors) {
          $.each(errors, function (key, value) {
            form
              .find('[name="' + key + '[]"]')
              .addClass('is-invalid')
              .next('.invalid-feedback')
              .text(value[0]);
          });
        } else {
          Swal.fire('Error', 'Terjadi kesalahan server', 'error');
        }
      }
    });
  });
});
