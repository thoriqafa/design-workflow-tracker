import $ from 'jquery';

window.$ = window.jQuery = $;

$(document).ready(function () {
  $('#form-create-remarks').on('submit', function (e) {
    e.preventDefault();

    let form = $(this);
    let btn = form.find('button[type=submit]');
    let id = form.data('id');

    btn.prop('disabled', true);

    $.ajax({
      url: '/work-progress/' + id,
      method: 'POST',
      data: form.serialize(),
      success: function (res) {
        $('#modalRemarks').modal('hide');
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

  $('#modalRemarks').on('hidden.bs.modal', function () {
    const modal = $(this);
    modal.removeData('mode');
    modal.find('form').removeData('id');

    $('#form-create-remarks')[0].reset();
    $('.is-invalid').removeClass('is-invalid');
    $('.invalid-feedback').text('');
  });
});
