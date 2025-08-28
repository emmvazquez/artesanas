<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div id="app" class="container py-4">
  <h2>Contenido del Módulo {{ idModulo }}</h2>

  <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#nuevoContenidoModal">
    Agregar Contenido
  </button>

  <table class="table table-bordered">
    <thead>
      <tr>
        <th>Tipo</th>
        <th>Archivo</th>
        <th>Duración</th>
        <th>Idioma</th>
        <th>Texto</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="item in contenido" :key="item.id">
        <td>{{ item.tipo }}</td>
        <td><a :href="item.urlArchivo" target="_blank">Ver archivo</a></td>
        <td>{{ item.duracionEstimada }} min</td>
        <td>{{ item.idioma }}</td>
        <td>{{ item.textoAdicional }}</td>
        <td>
          <button class="btn btn-sm btn-primary" @click="editarContenido(item.id)">Editar</button>
          <a :href="'/contenido/delete/' + item.id" class="btn btn-sm btn-danger">Eliminar</a>
        </td>
      </tr>
    </tbody>
  </table>

  <!-- Modal edición -->
  <div class="modal fade" id="contenidoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <form class="modal-content" @submit.prevent="guardarCambios" enctype="multipart/form-data">
        <div class="modal-header">
          <h5 class="modal-title">Editar Contenido</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" v-model="contenidoActual.idModulo">
          <div class="mb-2">
            <label>Tipo</label>
            <select v-model="contenidoActual.tipo" class="form-control">
              <option value="video">Video</option>
              <option value="audio">Audio</option>
              <option value="pdf">PDF</option>
              <option value="interactivo">Interactivo</option>
            </select>
          </div>
          <div class="mb-2">
            <label>Archivo (dejar vacío si no desea cambiar)</label>
            <input type="file" class="form-control" accept=".pdf,.mp4,.mp3,.html" @change="cargarArchivo">
            <small v-if="contenidoActual.urlArchivo">
              Actual: <a :href="contenidoActual.urlArchivo" target="_blank">Ver archivo</a>
            </small>
          </div>
          <div class="mb-2">
            <label>Texto adicional</label>
            <textarea v-model="contenidoActual.textoAdicional" class="form-control"></textarea>
          </div>
          <div class="mb-2">
            <label>Duración estimada (min)</label>
            <input v-model="contenidoActual.duracionEstimada" type="number" class="form-control">
          </div>
          <div class="mb-2">
            <label>Idioma</label>
            <select v-model="contenidoActual.idioma" class="form-control">
              <option value="es">Español</option>
              <option value="nah">Náhuatl</option>
              <option value="en">Inglés</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button class="btn btn-success">Guardar</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Modal nuevo -->
  <div class="modal fade" id="nuevoContenidoModal" tabindex="-1">
    <div class="modal-dialog">
      <form class="modal-content" action="/contenido/create" method="post" enctype="multipart/form-data">
        <div class="modal-header">
          <h5 class="modal-title">Nuevo Contenido</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="idModulo" :value="idModulo">
          <div class="mb-2">
            <label>Tipo</label>
            <select name="tipo" class="form-control" required>
              <option value="video">Video</option>
              <option value="audio">Audio</option>
              <option value="pdf">PDF</option>
              <option value="interactivo">Interactivo</option>
            </select>
          </div>
          <div class="mb-2">
            <label>Archivo</label>
            <input name="archivoSubido" type="file" class="form-control" accept=".pdf,.mp4,.mp3,.html" required>
          </div>
          <div class="mb-2">
            <label>Texto adicional</label>
            <textarea name="textoAdicional" class="form-control"></textarea>
          </div>
          <div class="mb-2">
            <label>Duración estimada (min)</label>
            <input name="duracionEstimada" type="number" class="form-control">
          </div>
          <div class="mb-2">
            <label>Idioma</label>
            <select name="idioma" class="form-control">
              <option value="es">Español</option>
              <option value="nah">Náhuatl</option>
              <option value="en">Inglés</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button class="btn btn-success">Guardar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Scripts Vue + Bootstrap -->
<script src="https://unpkg.com/vue@3/dist/vue.global.prod.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
const { createApp } = Vue;

createApp({
  data() {
    return {
      contenido: <?= json_encode($contenido) ?>,
      idModulo: <?= $idModulo ?>,
      contenidoActual: {},
      modal: null,
    };
  },
  mounted() {
    const el = document.getElementById('contenidoModal');
    if (el) this.modal = new bootstrap.Modal(el);
  },
  methods: {
    editarContenido(id) {
      fetch(`/contenido/edit/${id}`)
        .then(res => res.json())
        .then(data => {
          this.contenidoActual = data;
          this.modal?.show();
        });
    },
    cargarArchivo(e) {
      const file = e.target.files[0];
      if (!file) return;

      const tipoPermitido = this.contenidoActual.tipo;
      const extensionesPorTipo = {
        pdf: ['application/pdf'],
        video: ['video/mp4'],
        audio: ['audio/mpeg'],
        interactivo: ['text/html']
      };

      const tipoArchivo = file.type;
      const permitidos = extensionesPorTipo[tipoPermitido] || [];

      if (!permitidos.includes(tipoArchivo)) {
        alert(`El archivo no coincide con el tipo seleccionado (${tipoPermitido}).`);
        e.target.value = '';
        return;
      }

      this.contenidoActual.archivoSubido = file;
    },
    guardarCambios() {
      const formData = new FormData();
      for (let key in this.contenidoActual) {
        if (key !== 'archivoSubido') {
          formData.append(key, this.contenidoActual[key]);
        }
      }

      if (this.contenidoActual.archivoSubido) {
        formData.append('archivoSubido', this.contenidoActual.archivoSubido);
      }

      fetch(`/contenido/update/${this.contenidoActual.id}`, {
        method: 'POST',
        body: formData
      }).then(() => location.reload());
    }
  }
}).mount('#app');
</script>

<?= $this->endSection() ?>
