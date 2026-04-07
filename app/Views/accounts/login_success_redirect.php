<?= $this->extend('layouts/main_layout'); ?>

<?= $this->section('content') ?>

<section class="material-half-bg">
  <div class="cover"></div>
</section>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    Swal.fire({
      title: 'Inicio de sesion exitoso.',
      icon: 'success',
      timer: 900,
      showConfirmButton: false,
      allowOutsideClick: false,
      allowEscapeKey: false
    }).then(function () {
      window.location.href = <?= json_encode($redirectUrl) ?>;
    });
  });
</script>

<?= $this->endSection() ?>
