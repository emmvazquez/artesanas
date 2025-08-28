<?= $this->extend('layouts/landing') ?>
<?= $this->section('contenido') ?>

<div class="container py-5">
  <h2><?= lang('Mensajes.iniciar_sesion') ?></h2>
  <?php if(session()->getFlashdata('error')): ?>
    <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
  <?php endif; ?>
  <form action="/auth/acceder" method="post">
    <div class="mb-3">
      <label for="usuario" class="form-label"><?= lang('Mensajes.usuario') ?></label>
      <input type="text" name="usuario" class="form-control" required>
    </div>
    <div class="mb-3">
      <label for="password" class="form-label"><?= lang('Mensajes.contrasena') ?></label>
      <input type="password" name="password" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary"><?= lang('Mensajes.entrar') ?></button>
  </form>
</div>

<?= $this->endSection() ?>
