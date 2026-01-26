import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

/*
  Add custom scripts here
*/
import.meta.glob([
  '../assets/img/**',
  // '../assets/json/**',
  '../assets/vendor/fonts/**'
]);

import Swal from 'sweetalert2';
window.Swal = Swal;

import flatpickr from 'flatpickr';
window.flatpickr = flatpickr;

window.Toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 2200,
  timerProgressBar: true,
  iconColor: '#fff',
  didOpen: toast => {
    toast.addEventListener('mouseenter', Swal.stopTimer);
    toast.addEventListener('mouseleave', Swal.resumeTimer);
  },
  customClass: {
    popup: 'colored-toast'
  }
});

window.notify = {
  success(message = 'Berhasil') {
    Toast.fire({
      icon: 'success',
      title: message
    });
  },

  error(message = 'Terjadi kesalahan') {
    Toast.fire({
      icon: 'error',
      title: message
    });
  },

  warning(message) {
    Toast.fire({
      icon: 'warning',
      title: message
    });
  },

  info(message) {
    Toast.fire({
      icon: 'info',
      title: message
    });
  }
};
