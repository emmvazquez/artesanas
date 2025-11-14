<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<?php $porcentaje = $porcentaje ?? 0; ?>

<h1 class="mb-3"><?= esc($curso['titulo']) ?></h1>
<p class="text-muted"><?= esc($curso['descripcion']) ?></p>

<!-- Barra de progreso -->
<div class="mb-4">
  <h5>Progreso del curso</h5>
  <div class="progress" style="height: 25px;">
    <div id="barraProgreso"
      class="progress-bar progress-bar-striped bg-success"
      role="progressbar"
      style="width: <?= $porcentaje ?>%;"
      aria-valuenow="<?= $porcentaje ?>"
      aria-valuemin="0"
      aria-valuemax="100">
      <?= $porcentaje ?>%
    </div>
  </div>
</div>

<?php if (empty($modulos)): ?>
  <div class="alert alert-info">Este curso aún no tiene módulos publicados.</div>
<?php else: ?>
  <?php foreach ($modulos as $modulo): ?>
    <div class="card mb-3 shadow-sm">
      <div class="card-body">
        <!-- <h4 class="card-title mb-2"><?= esc($modulo['titulo']) ?></h4> -->
        <h4 class="card-title mb-2" data-id-modulo="<?= esc($modulo['id']) ?>">
          <?= esc($modulo['titulo']) ?>
        </h4>

        <p class="mb-3 text-muted"><?= esc($modulo['descripcion']) ?></p>

        <?php $contenidos = $contenidosPorModulo[$modulo['id']] ?? []; ?>

        <?php if (empty($contenidos)): ?>
          <div class="text-muted">No hay contenidos en este módulo todavía.</div>
        <?php else: ?>
          <ul class="list-group">
            <?php foreach ($contenidos as $c): ?>
              <?php $url = $c['urlArchivo'] ?? ''; ?>
              <li class="list-group-item d-flex justify-content-between align-items-center">
                <div>
                  <strong><?= esc(ucfirst($c['tipo'])) ?>:</strong>
                  <?= esc($c['textoAdicional'] ?? 'Contenido') ?>
                </div>

                <?php if (!empty($url)): ?>
                  <button
                    class="btn btn-sm btn-primary ver-recurso"
                    data-bs-toggle="modal"
                    data-bs-target="#modalRecurso"
                    data-tipo="<?= esc($c['tipo']) ?>"
                    data-url="<?= base_url($url) ?>"
                    data-modulo="<?= esc($modulo['id']) ?>">
                    Ver <?= ucfirst($c['tipo']) ?>
                  </button>

                <?php else: ?>
                  <button class="btn btn-sm btn-secondary" disabled>Sin recurso</button>
                <?php endif; ?>
              </li>
            <?php endforeach; ?>

          </ul>
        <?php endif; ?>
      </div>
    </div>
  <?php endforeach; ?>
<?php endif; ?>


<!-- Modal Bootstrap para visualizar los recursos -->
<div class="modal fade" id="modalRecurso" tabindex="-1" aria-labelledby="modalRecursoLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalRecursoLabel">Recurso del módulo</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body text-center" id="modalContenido">
        <div class="text-muted">Selecciona un recurso para visualizarlo.</div>
      </div>
    </div>
  </div>
</div>

<!-- Script para manejar los recursos dinámicos -->
<script>
  document.addEventListener('DOMContentLoaded', () => {
    const modalBody = document.getElementById('modalContenido');
    const botones = document.querySelectorAll('.ver-recurso');

    botones.forEach(btn => {
      btn.addEventListener('click', () => {
        const tipo = btn.getAttribute('data-tipo');
        const url = btn.getAttribute('data-url');
        const idModulo = btn.closest('.card').querySelector('.card-title').dataset.idModulo;
        let contenidoHTML = '';

        // Mostrar recurso
        switch (tipo.toLowerCase()) {
          case 'video':
            contenidoHTML = `<video controls width="100%" class="rounded shadow">
              <source src="${url}" type="video/mp4">
              Tu navegador no soporta video HTML5.
            </video>`;
            break;
          case 'audio':
            contenidoHTML = `<audio controls class="w-100 mt-3">
              <source src="${url}" type="audio/mpeg">
              Tu navegador no soporta audio HTML5.
            </audio>`;
            break;
          case 'pdf':
            contenidoHTML = `<iframe src="${url}" width="100%" height="600px" style="border:none;"></iframe>`;
            break;
          default:
            contenidoHTML = `<a href="${url}" target="_blank" class="btn btn-outline-primary">
              Abrir recurso externo
            </a>`;
        }

        modalBody.innerHTML = contenidoHTML;

        // Registrar progreso al abrir
        fetch('<?= base_url('progreso/registrar') ?>', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: new URLSearchParams({
              idModulo: btn.closest('.card').dataset.idModulo
            })
          })
          .then(res => res.json())
          .then(data => {
            if (data.success) {
              actualizarProgreso();
            }
          });
      });
    });

    // Actualizar barra visualmente
    function actualizarProgreso() {
      const barra = document.getElementById('barraProgreso');
      let valor = parseInt(barra.getAttribute('aria-valuenow')) || 0;
      if (valor < 100) {
        const nuevo = Math.min(valor + (100 / <?= count($modulos) ?>), 100);
        barra.style.width = nuevo + '%';
        barra.setAttribute('aria-valuenow', nuevo);
        barra.textContent = Math.round(nuevo) + '%';
      }
    }
  });
</script>


<?= $this->endSection() ?>