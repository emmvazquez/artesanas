<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div id="app" class="container py-4">
  <h2 class="mb-4">Cursos</h2>

  <!-- Botón Agregar -->
  <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#nuevoCursoModal">
    Agregar Nuevo Curso
  </button>

  <!-- Tabla -->
  <table class="table table-striped">
    <thead>
      <tr>
        <th>Título</th>
        <th>Descripción</th>
        <th>Portada</th>
        <th>Idiomas</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="curso in cursos" :key="curso.id">
        <td>{{ curso.titulo }}</td>
        <td>{{ curso.descripcion }}</td>
        <td>
          <img :src="curso.imagenPortada" alt="Portada" width="80" v-if="curso.imagenPortada">
        </td>
        <td>{{ curso.idiomasDisponibles }}</td>
        <td>
        <a :href="'/modulo/index/' + curso.id" class="btn btn-sm btn-info">Ver Módulos</a>
        <button class="btn btn-sm btn-primary" @click="editarCurso(curso.id)">Editar</button>
        <a :href="'/curso/delete/' + curso.id" class="btn btn-sm btn-danger">Eliminar</a>
      </td>

      </tr>
    </tbody>
  </table>

  <!-- Modal de edición -->
  <div class="modal fade" id="cursoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <form class="modal-content" @submit.prevent="guardarCambios" enctype="multipart/form-data">
        <div class="modal-header">
          <h5 class="modal-title">Editar Curso</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <div class="mb-2">
            <label>Título</label>
            <input v-model="cursoActual.titulo" class="form-control" required>
          </div>
          <div class="mb-2">
            <label>Descripción</label>
            <textarea v-model="cursoActual.descripcion" class="form-control"></textarea>
          </div>
          <div class="mb-2">
            <label>Imagen de Portada</label>
            <input type="file" class="form-control" @change="cargarImagen">
            <img :src="cursoActual.imagenPortada" v-if="cursoActual.imagenPortada" class="mt-2" width="100">
          </div>
          <div class="mb-2">
            <label>Idiomas disponibles</label>
            <select v-model="cursoActual.idiomasDisponibles" class="form-control">
              <option value="es">Español</option>
              <option value="nah">Náhuatl</option>
              <option value="en">Inglés</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-success">Guardar</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Modal nuevo curso (solo Bootstrap) -->
  <div class="modal fade" id="nuevoCursoModal" tabindex="-1" aria-labelledby="nuevoCursoLabel" aria-hidden="true">
    <div class="modal-dialog">
      <form class="modal-content" action="/curso/create" method="post" enctype="multipart/form-data">
        <div class="modal-header">
          <h5 class="modal-title" id="nuevoCursoLabel">Nuevo Curso</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <div class="mb-2">
            <label>Título</label>
            <input name="titulo" class="form-control" required>
          </div>
          <div class="mb-2">
            <label>Descripción</label>
            <textarea name="descripcion" class="form-control"></textarea>
          </div>
          <div class="mb-2">
            <label>Imagen de Portada</label>
            <input name="imagenPortada" type="file" class="form-control">
          </div>
          <div class="mb-2">
            <label>Idiomas disponibles</label>
            <select name="idiomasDisponibles" class="form-control">
              <option value="es">Español</option>
              <option value="nah">Náhuatl</option>
              <option value="en">Inglés</option>
            </select>
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

<!-- Scripts -->
<script src="https://unpkg.com/vue@3/dist/vue.global.prod.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
const { createApp } = Vue;

createApp({
  data() {
    return {
      cursos: <?= json_encode($cursos) ?>,
      cursoActual: {},
      modal: null,
    };
  },
  mounted() {
    const modalEl = document.getElementById('cursoModal');
    if (modalEl) {
      this.modal = new bootstrap.Modal(modalEl);
    }
  },
  methods: {
    editarCurso(id) {
      fetch(`/curso/edit/${id}`)
        .then(res => res.json())
        .then(data => {
          this.cursoActual = data;
          this.modal?.show();
        });
    },
    guardarCambios() {
      const formData = new FormData();

      for (let key in this.cursoActual) {
        formData.append(key, this.cursoActual[key]);
      }

      const inputFile = document.querySelector('#cursoModal input[type="file"]');
      if (inputFile && inputFile.files.length > 0) {
        formData.append('imagenPortada', inputFile.files[0]);
      }

      fetch(`/curso/update/${this.cursoActual.id}`, {
        method: 'POST',
        body: formData
      }).then(() => location.reload());
    },
    cargarImagen(event) {
      const file = event.target.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = e => {
          this.cursoActual.imagenPortada = e.target.result;
        };
        reader.readAsDataURL(file);
      }
    }
  }
}).mount('#app');
</script>

<?= $this->endSection() ?>
