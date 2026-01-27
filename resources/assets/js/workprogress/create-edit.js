import $ from 'jquery';
import flatpickr from 'flatpickr';
import 'flatpickr/dist/flatpickr.min.css';

window.$ = window.jQuery = $;

('use strict');

$(document).ready(function () {
  $('#modalCreateEdit').on('shown.bs.modal', function () {
    const modal = $(this);
    const flatpickrDateTime = this.querySelector('#flatpickr-datetime');

    if (!flatpickrDateTime) return;

    const mode = modal.data('mode') || 'create';
    const serverDate = modal.data('emailDate');

    if (flatpickrDateTime) {
      if (!flatpickrDateTime._flatpickr) {
        flatpickr(flatpickrDateTime, {
          enableTime: true,
          enableSeconds: true,
          dateFormat: 'Y-m-d H:i:s',
          static: true,
          allowInput: true,
          time_24hr: true,
          defaultDate: new Date(),
          appendTo: document.body
        });
      } else {
        flatpickrDateTime._flatpickr.setDate(mode === 'edit' ? serverDate : new Date(), true);
      }
    }
  });

  $('#form-create-task').on('submit', function (e) {
    e.preventDefault();

    const modal = $('#modalCreateEdit');
    const mode = modal.data('mode') || 'create';

    let form = $(this);
    let btn = form.find('button[type=submit]');
    let id = form.data('id');

    const urlForm = mode === 'edit' ? '/work-progress/' + id : '/work-progress';

    btn.prop('disabled', true);

    $.ajax({
      url: baseUrl + urlForm,
      method: 'POST',
      data: form.serialize(),
      success: function (res) {
        $('#modalCreateEdit').modal('hide');
        form[0].reset();
        btn.prop('disabled', false);

        $('#workProgressTable').DataTable().ajax.reload(null, false);

        Swal.fire({
          icon: 'success',
          title: 'Berhasil',
          text: res.message,
          timer: 1500,
          showConfirmButton: false
        });
      },
      error: function (xhr) {
        btn.prop('disabled', false);

        if (xhr.status === 422) {
          let errors = xhr.responseJSON.errors;
          $.each(errors, function (key, val) {
            let input = form.find('[name="' + key + '"]');
            input.addClass('is-invalid');
            input.next('.invalid-feedback').text(val[0]);
          });
        }
      }
    });
  });

  $('#modalCreateEdit').on('hidden.bs.modal', function () {
    const modal = $(this);
    modal.removeData('mode');
    modal.find('form').removeData('id');

    $('#form-create-task')[0].reset();
    $('.is-invalid').removeClass('is-invalid');
    $('.invalid-feedback').text('');
  });
});
