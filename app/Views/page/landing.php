<?= $this->extend('layouts/landing') ?>

<?= $this->section('contenido') ?>


<div class="container py-5">
  <div class="row align-items-center">
    <div class="col-md-6 text-center text-md-start">
      <h1><?= lang('Mensajes.bienvenida') ?></h1>
        <p><?= lang('Mensajes.descripcion') ?></p>
      <a href="#cursos" class="btn btn-primary btn-lg mt-3"><?= lang('Mensajes.ver_cursos') ?></a>
    </div>
    <div class="col-md-6 text-center mt-4 mt-md-0">
      <img src="<?= base_url('assets/img/artesanas-ilustracion.png') ?>" alt="Artesanas" class="img-fluid rounded">
    </div>
  </div>
</div>

<!-- Cursos -->
<section class="bg-light py-5" id="cursos">
  <div class="container text-center">
    <h2 class="fw-bold mb-4"><?= lang('Mensajes.que_aprenderas') ?></h2>
    <div class="row g-4">
      <?php foreach ($cursos as $curso): ?>
        <div class="col-md-4">
          <div class="p-4 border rounded h-100 shadow-sm bg-white">
            <h5 class="fw-bold"><?= esc($curso['titulo']) ?></h5>
            <p><?= esc($curso['descripcion']) ?></p>
            <span class="badge bg-secondary"><?= esc(ucfirst($curso['idioma'] ?? 'Español')) ?></span>
            <a href="<?= base_url('curso/' . $curso['id']) ?>" class="btn btn-primary mt-2"><?= lang('Mensajes.ver_mas') ?></a>

          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- Contacto -->
<section class="py-5" id="contacto">
  <div class="container text-center">
    <h2 class="fw-bold mb-4">Contacto</h2>
    <p>¿Tienes dudas o sugerencias? Escríbenos a <a href="mailto:contacto@artesanas.mx">contacto@artesanas.mx</a></p>
  </div>
</section>
<?= $this->endSection() ?>
