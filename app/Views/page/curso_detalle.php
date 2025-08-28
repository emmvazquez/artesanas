<?= $this->extend('layouts/landing') ?>
<?= $this->section('contenido') ?>

<div class="container py-5">
  <div class="row">
    <div class="col-12">
      <h1 class="fw-bold mb-3"><?= esc($curso['titulo']) ?></h1>
      <p class="lead"><?= esc($curso['descripcion']) ?></p>
      <ul class="list-unstyled">
        <li><strong>Idioma:</strong> <?= esc(ucfirst($curso['idiomasDisponibles'])) ?></li>
        <li><strong>Nivel:</strong> <?= esc(ucfirst($curso['nivel'] ?? 'Básico')) ?></li>
      </ul>
      <?php if ($estaLogeado): ?>
  <div class="my-4 text-center">
    <?php if ($usuarioInscrito): ?>
      <a href="<?= base_url('dashboard/curso/' . $curso['id']) ?>" class="btn btn-success btn-lg">
        <i class="bi bi-play-circle-fill me-1"></i> Continuar aprendizaje
      </a>
    <?php else: ?>
      <a href="<?= base_url('curso/inscribirse/' . $curso['id']) ?>" class="btn btn-primary btn-lg">
        <i class="bi bi-person-plus-fill me-1"></i> <?= lang('Mensajes.inscribirme') ?>
      </a>
    <?php endif; ?>
  </div>
<?php else: ?>
  <div class="alert alert-info mt-4 text-center">
    <i class="bi bi-info-circle me-1"></i> <?= lang('Mensajes.debes_iniciar') ?>.
  </div>
<?php endif; ?>

    </div>
  </div>

  <hr>

  <div class="row mt-4">
    <div class="col-12">
      <h2 class="mb-3">Módulos del curso</h2>

      <?php if (empty($modulos)): ?>
        <p class="text-muted">Este curso aún no tiene módulos asignados.</p>
      <?php else: ?>
        <ol class="list-group list-group-numbered">
          <?php foreach ($modulos as $modulo): ?>
            <li class="list-group-item">
              <h5 class="mb-1"><?= esc($modulo['titulo']) ?></h5>
              <p class="mb-0"><?= esc($modulo['descripcion']) ?></p>
            </li>
          <?php endforeach; ?>
        </ol>
      <?php endif; ?>
    </div>
  </div>
</div>

<?= $this->endSection() ?>
