<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div id="app" class="container py-4">
  <h2 class="mb-3">Módulos del Curso {{ idCurso }}</h2>

  <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#nuevoModuloModal">
    Agregar Módulo
  </button>

  <table class="table table-bordered">
    <thead>
      <tr>
        <th>Orden</th>
        <th>Título</th>
        <th>Descripción</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="modulo in modulos" :key="modulo.id">
        <td>{{ modulo.orden }}</td>
        <td>{{ modulo.titulo }}</td>
        <td>{{ modulo.descripcion }}</td>
        <td>
            <a :href="'/contenido/index/' + modulo.id" class="btn btn-sm btn-info me-2">Ver Contenidos</a>
          <button class="btn btn-sm btn-primary me-2" @click="editarModulo(modulo.id)">Editar</button>
          <a :href="'/modulo/delete/' + modulo.id" class="btn btn-sm btn-danger me-2">Eliminar</a>
          <a :href="'/preguntas/index/' + modulo.id" class="btn btn-sm btn-success">Agregar preguntas</a>
        </td>
      </tr>
    </tbody>
  </table>

  <!-- Modal editar -->
  <div class="modal fade" id="moduloModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <form class="modal-content" @submit.prevent="guardarCambios">
        <div class="modal-header">
          <h5 class="modal-title">Editar Módulo</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" v-model="moduloActual.idCurso">
          <div class="mb-2">
            <label>Título</label>
            <input v-model="moduloActual.titulo" class="form-control" required>
          </div>
          <div class="mb-2">
            <label>Descripción</label>
            <textarea v-model="moduloActual.descripcion" class="form-control"></textarea>
          </div>
          <div class="mb-2">
            <label>Orden</label>
            <input v-model="moduloActual.orden" type="number" class="form-control">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-success">Guardar</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Modal nuevo -->
  <div class="modal fade" id="nuevoModuloModal" tabindex="-1">
    <div class="modal-dialog">
      <form class="modal-content" action="/modulo/create" method="post">
        <div class="modal-header">
          <h5 class="modal-title">Nuevo Módulo</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="idCurso" :value="idCurso">
          <div class="mb-2">
            <label>Título</label>
            <input name="titulo" class="form-control" required>
          </div>
          <div class="mb-2">
            <label>Descripción</label>
            <textarea name="descripcion" class="form-control"></textarea>
          </div>
          <div class="mb-2">
            <label>Orden</label>
            <input name="orden" type="number" class="form-control">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-success">Guardar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="https://unpkg.com/vue@3/dist/vue.global.prod.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
const { createApp } = Vue;

createApp({
  data() {
    return {
      modulos: <?= json_encode($modulos) ?>,
      idCurso: <?= $idCurso ?>,
      moduloActual: {},
      modal: null
    };
  },
  mounted() {
    const el = document.getElementById('moduloModal');
    if (el) {
      this.modal = new bootstrap.Modal(el);
    }
  },
  methods: {
    editarModulo(id) {
      fetch(`/modulo/edit/${id}`)
        .then(res => res.json())
        .then(data => {
          this.moduloActual = data;
          this.modal?.show();
        });
    },
    guardarCambios() {
      const formData = new FormData();
      for (let key in this.moduloActual) {
        formData.append(key, this.moduloActual[key]);
      }
      fetch(`/modulo/update/${this.moduloActual.id}`, {
        method: 'POST',
        body: formData
      }).then(() => location.reload());
    }
  }
}).mount('#app');
</script>

<?= $this->endSection() ?>
