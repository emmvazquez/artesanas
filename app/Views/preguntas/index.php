<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div id="app" class="container py-4">
    <h2 class="mb-3">Preguntas del Módulo {{ idModulo }}</h2>

    <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#nuevaPregunta">
        Agregar Pregunta
    </button>

    <table class="table table-striped table-hover">
        <thead class="table-primary">
            <tr>
                <th>Pregunta</th>
                <th>Opción 1</th>
                <th>Opción 2</th>
                <th>Opción 3</th>
                <th>Respuesta Correcta</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="pregunta in preguntas" :key="preguntas.id">
                <td>{{ pregunta.pregunta }}</td>
                <td>{{ pregunta.opcion1 }}</td>
                <td>{{ pregunta.opcion2 }}</td>
                <td>{{ pregunta.opcion3 }}</td>
                <td>{{ pregunta.respuestaCorrecta }}</td>
                <td>
                    <button class="btn btn-sm btn-primary me-1" @click="editarPregunta(pregunta.id)">Editar</button>
                    <a :href="'/preguntas/delete/' + pregunta.id" class="btn btn-sm btn-danger me-2">Eliminar</a>
                </td>
            </tr>
        </tbody>
    </table>

    <!-- Modal Editar -->
    <div class="modal fade" id="modalEditar" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form class="modal-content" @submit.prevent="guardarCambios">
                <div class="modal-header">
                    <h5 class="modal-title">Editar Preguntas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" v-model="preguntaActual.idModulo">

                    <div class="mb-2">
                        <label>Pregunta</label>
                        <input type="text" v-model="preguntaActual.idModulo" required>
                    </div>
                    <div class="mb-2">
                        <label>Opción 1</label>
                        <input type="text" v-model="preguntaActual.opcion1">
                    </div>
                    <div class="mb-2">
                        <label>Opción 2</label>
                        <input type="text" v-model="preguntaActual.opcion2">
                    </div>
                    <div class="mb-2">
                        <label>Opción 3</label>
                        <input type="text" v-model="preguntaActual.opcion3">
                    </div>
                    <div class="mb-2">
                        <label>Respuesta Correcta</label>
                        <input type="text" v-model="preguntaActual.respuestaCorrecta">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button class="btn btn-success" type="submit">Guardar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal nuevo-->
    <div class="modal fade" id="nuevaPregunta" tabindex="-1">
        <div class="modal-dialog">
            <form class="modal-content" action="/preguntas/create" method="post">
                <div class="modal-header">
                    <h5 class="modal-title">Nueva Pregunta</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="idModulo" :value="idModulo">
                    <div class="mb-2">
                        <label>Pregunta</label>
                        <input name="pregunta" class="form-control" required>
                    </div>
                    <div class="mb-2">
                        <label>Opción 1</label>
                        <input name="opcion1" class="form-control">
                    </div>
                    <div class="mb-2">
                        <label>Opción 2</label>
                        <input name="opcion2" class="form-control">
                    </div>
                    <div class="mb-2">
                        <label>Opción 3</label>
                        <input name="opcion3" class="form-control">
                    </div>
                    <div class="mb-2">
                        <label>Respuesta Correcta</label>
                        <input type="number" name="respuestaCorrecta" class="form-control">
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
                preguntas: <?= json_encode($preguntas) ?>,
                idModulo: <?= $idModulo ?>,
                preguntaActual: {},
                modal: null,
            };
        },
        mounted() {
            const el = document.getElementById('modalEditar');
            if (el) {
                this.modal = new bootstrap.Modal(el);
            }
        },
        methods: {
            editarPregunta(id) {
                fetch(`/preguntas/edit/${id}`)
                    .then(res => res.json())
                    .then(data => {
                        this.preguntaActual = data;
                        this.modal?.show();
                    });
            },
            guardarCambios() {
                const formData = new FormData();
                for (let key in this.preguntaActual) {
                    formData.append(key, this.preguntaActual[key]);
                }
                fetch(`/preguntas/update/${this.preguntaActual.id}`, {
                    method: 'POST',
                    body: formData
                }).then(() => location.reload());
            }
        }
    }).mount('#app');
</script>

<?= $this->endSection() ?>