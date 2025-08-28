<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= esc($titulo ?? 'Artesanas de Hueyapan') ?></title>

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;600;700&display=swap" rel="stylesheet">

  <!-- Íconos -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

  <!-- Estilos personalizados -->
  <style>
  body {
    font-family: 'Quicksand', sans-serif;
    background-color: #FFF;
    color: #333;
  }

  .navbar {
    background-color: #7E57C2;
  }

  .navbar-brand,
  .nav-link,
  .footer-text {
    color: #fff !important;
  }

  .btn-primary {
    background-color: #7E57C2;
    border: none;
  }

  .btn-primary:hover {
    background-color: #5E35B1;
  }

  .badge.bg-secondary {
    background-color: #D1C4E9 !important;
    color: #4A148C;
  }

  footer {
    background-color: #7E57C2;
    color: #fff;
    padding: 20px 0;
  }

  h1, h2, h5 {
    color: #4A148C;
  }

  .shadow-sm {
    box-shadow: 0 0.125rem 0.25rem rgba(126, 87, 194, 0.15);
  }

  .list-group-item {
    background-color: #ffffff;
    border: 1px solid #e0d4f0;
  }

  .highlight {
    color: #7E57C2;
  }

  section.bg-light {
    background-color: #fff !important;
  }


  .btn-success {
  background-color: #43A047;
  border: none;
}
.btn-success:hover {
  background-color: #388E3C;
}

</style>


</head>
<body  class="d-flex flex-column min-vh-100">

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg shadow-sm">
  <div class="container">
    <a class="navbar-brand fw-bold" href="<?=base_url();?>">
      <i class="bi bi-flower2 me-1"></i>Artesanas
    </a>
    <button class="navbar-toggler bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav">
  <li class="nav-item"><a class="nav-link" href="#cursos"><?= lang('Mensajes.cursos') ?></a></li>
  <li class="nav-item"><a class="nav-link" href="#contacto"><?= lang('Mensajes.contacto') ?></a></li>
  <li class="nav-item"><a class="nav-link" href="<?= base_url('auth/login') ?>"><?= lang('Mensajes.iniciar_sesion') ?> </a></li>
</ul>

    </div>
  </div>
</nav>

<!-- CONTENIDO -->
<main  class="flex-fill">
  <?= $this->renderSection('contenido') ?>
</main>

<!-- FOOTER -->
<footer class="text-center mt-5">
  <div class="container">
    <p class="mb-0 footer-text">© <?= date('Y') ?> Artesanas de Hueyapan · Inspirando con tradición · Teziutlán, Puebla</p>
  </div>
</footer>

<!-- JS Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
