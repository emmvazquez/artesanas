<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h1 class="mb-3"><?= esc($curso['titulo']) ?></h1>
<p class="text-muted"><?= esc($curso['descripcion']) ?></p>

<?php if (empty($modulos)): ?>
  <div class="alert alert-info">Este curso aún no tiene módulos publicados.</div>
<?php else: ?>
  <?php foreach ($modulos as $modulo): ?>
    <div class="card mb-3">
      <div class="card-body">
        <h4 class="card-title mb-2"><?= esc($modulo['titulo']) ?></h4>
        <p class="mb-3"><?= esc($modulo['descripcion']) ?></p>

        <?php $contenidos = $contenidosPorModulo[$modulo['id']] ?? []; ?>
        <?php if (empty($contenidos)): ?>
          <div class="text-muted">No hay contenidos en este módulo todavía.</div>
        <?php else: ?>
          <ul class="list-group">
            <?php foreach ($contenidos as $c): ?>
              <li class="list-group-item d-flex justify-content-between align-items-center">
                <div>
                  <strong><?= esc(ucfirst($c['tipo'])) ?>:</strong>
                  <?= esc($c['titulo'] ?? $c['descripcion'] ?? 'Contenido') ?>
                </div>
                <?php if (!empty($c['urlContenido'])): ?>
                  <a class="btn btn-sm btn-primary" target="_blank" href="<?= esc($c['urlContenido']) ?>">
                    Abrir
                  </a>
                <?php endif; ?>
              </li>
            <?php endforeach; ?>
          </ul>
        <?php endif; ?>
      </div>
    </div>
  <?php endforeach; ?>
<?php endif; ?>

<?= $this->endSection() ?>
