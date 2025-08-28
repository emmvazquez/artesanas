<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
  <h2 class="mb-4 text-center">Todos los cursos</h2>
  <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-4">
    <?php foreach ($cursos as $curso): ?>
      <div class="col">
        <div class="card text-center shadow-sm border-0">
          <div class="card-body">
            <div class="rounded-circle bg-light d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 100px; height: 100px; overflow: hidden;">
              <?php if ($curso['imagenPortada']): ?>
                <img src="<?= base_url('uploads/' . $curso['imagenPortada']) ?>" class="img-fluid" alt="icono" style="max-width: 100%; max-height: 100%;">
              <?php else: ?>
                <i class="bi bi-book" style="font-size: 2rem;"></i>
              <?php endif; ?>
            </div>
            <h6 class="card-title"><?= esc($curso['titulo']) ?></h6>
            <?php if (in_array($curso['id'], $cursosInscritos)): ?>
              <a href="<?= base_url("curso/{$curso['id']}") ?>" class="btn btn-success btn-sm mt-2">Continuar</a>
            <?php else: ?>
              <form action="<?= base_url("dashboard/inscribirse/{$curso['id']}") ?>" method="post">
                <button class="btn btn-outline-primary btn-sm mt-2" type="submit">Inscribirme</button>
              </form>
            <?php endif; ?>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>

<?= $this->endSection() ?>
