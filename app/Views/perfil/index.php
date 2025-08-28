<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<h3 class="mb-4">👥 Lista de Perfiles</h3>

<table class="table table-striped table-hover">
  <thead class="table-success">
    <tr>
      <th>ID</th>
      <th>Usuario</th>
      <th>Nombre</th>
      <th>Idioma</th>
      <th>Letra</th>
      <th>Audio</th>
      <th>Acciones</th>
    </tr>
  </thead>
  <tbody>
    <tr v-for="perfil in perfiles" :key="perfil.id">
      <td>{{ perfil.id }}</td>
      <td>{{ perfil.idUsuario }}</td>
      <td>{{ perfil.nombre }} {{ perfil.apellidoPaterno }} {{ perfil.apellidoMaterno }}</td>
      <td>{{ perfil.idiomaPreferido }}</td>
      <td>{{ perfil.tamLetra }}</td>
      <td>{{ perfil.velocidadAudio }}</td>
      <td>
        <button class="btn btn-sm btn-primary me-1" @click="editarPerfil(perfil.id)">
          <i class="bi bi-pencil"></i>
        </button>
        <button class="btn btn-sm btn-danger" @click="eliminarPerfil(perfil.id)">
          <i class="bi bi-trash"></i>
        </button>
      </td>
    </tr>
  </tbody>
</table>

<!-- Modal de edición -->
<div class="modal fade" id="modalEditar" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form class="modal-content" @submit.prevent="guardarCambios">
      <div class="modal-header">
        <h5 class="modal-title">Editar Perfil</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body row g-3">
        <div class="col-md-6">
          <label class="form-label">Nombre</label>
          <input v-model="perfilActual.nombre" class="form-control">
        </div>
        <div class="col-md-6">
          <label class="form-label">Apellido Paterno</label>
          <input v-model="perfilActual.apellidoPaterno" class="form-control">
        </div>
        <div class="col-md-6">
          <label class="form-label">Apellido Materno</label>
          <input v-model="perfilActual.apellidoMaterno" class="form-control">
        </div>
        <div class="col-md-6">
  <label class="form-label">Sexo</label>
  <select class="form-select" v-model="perfilActual.sexo">
    <option disabled value="">Selecciona una opción</option>
    <option>Hombre</option>
    <option>Mujer</option>
  </select>
</div>

        <div class="col-md-6">
          <label class="form-label">Idioma</label>
          <select v-model="perfilActual.idiomaPreferido" class="form-select">
            <option value="es">Español</option>
            <option value="nah">Nahuatl</option>
          </select>
        </div>
        <div class="col-md-6">
          <label class="form-label">Tamaño letra</label>
          <select v-model="perfilActual.tamLetra" class="form-select">
            <option>chico</option>
            <option>mediano</option>
            <option>grande</option>
          </select>
        </div>
        <div class="col-md-6">
          <label class="form-label">Velocidad audio</label>
          <select v-model="perfilActual.velocidadAudio" class="form-select">
            <option>lento</option>
            <option>normal</option>
            <option>rapido</option>
          </select>
        </div>
        <div class="col-12 form-check">
          <input type="checkbox" class="form-check-input" v-model="perfilActual.contrasteAlto" id="contrasteAlto">
          <label class="form-check-label" for="contraste">Contraste alto</label>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button"  class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button class="btn btn-success" type="submit">Guardar</button>
      </div>
    </form>
  </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
const { createApp } = Vue;

createApp({
  data() {
    return {
      perfiles: [],
      perfilActual: {},
      modal: null
    };
  },
  mounted() {
    this.cargarPerfiles();
    this.modal = new bootstrap.Modal(document.getElementById('modalEditar'));
  },
  methods: {
    cargarPerfiles() {
      fetch('/perfil/')
        .then(res => res.json())
        .then(data => this.perfiles = data);
    },
    editarPerfil(id) {
  fetch(`edit/${id}`)
    .then(res => res.json())
    .then(data => {
      data.contrasteAlto = Boolean(data.contrasteAlto); 
      this.perfilActual = data;
      this.$nextTick(() => {
        this.modal.show();
      });
      console.info("Perfil cargado:", data);
    })
    .catch(err => {
      alert("Error al cargar el perfil");
      console.error(err);
    });
}
,
    guardarCambios() {
      fetch(`update/${this.perfilActual.id}`, {
        method: 'PUT',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(this.perfilActual)
      })
      .then(() => {
        this.modal.hide();
        this.cargarPerfiles();
        alert('Perfil actualizado');
      });
    },
    eliminarPerfil(id) {
      if (confirm('¿Seguro que deseas eliminar este perfil?')) {
        fetch(`/perfil/delete/${id}`, { method: 'DELETE' })
          .then(() => {
            this.cargarPerfiles();
            alert('Perfil eliminado');
          });
      }
    }
  }
}).mount('#app');
</script>
<?= $this->endSection() ?>
