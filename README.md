#  Plataforma Artesanas – Documentación de Base de Datos

**Fecha de creación:** 6 de junio de 2025  
**Desarrollado con:** MySQL / MariaDB  
**Optimizado para:** CodeIgniter 4 (soporte de soft deletes y timestamps)  
**Convención de nombres:** lowerCamelCase en nombres de tablas y campos

---

## Tablas incluidas

### 1. `usuarios`
Contiene la información básica de acceso para cada cuenta registrada.

| Campo         | Tipo             | Descripción                                 |
|---------------|------------------|---------------------------------------------|
| `id`          | INT (PK, AI)     | ID único del usuario                        |
| `usuario`     | VARCHAR(100)     | Nombre de usuario (único)                   |
| `password`    | VARCHAR(255)     | Contraseña encriptada                       |
| `tipo`        | ENUM             | 'artesana' o 'admin'                        |
| `fechaRegistro` | DATETIME       | Fecha de registro                           |
| `created_at`  | DATETIME         | Generado automáticamente por CI4            |
| `updated_at`  | DATETIME         | Actualización automática CI4                |
| `deleted_at`  | DATETIME         | Soporte para eliminación lógica             |

---

### 2. `perfiles`
Datos personales y configuraciones de accesibilidad para cada usuaria.

# 📂 Módulo: Perfil

## 🎯 Objetivo

El módulo **Perfil** permite gestionar los datos personales y preferencias de accesibilidad de cada usuario registrado en la plataforma **Artesanas**, tales como nombre, apellidos, sexo, idioma, tamaño de letra, velocidad de audio, y contraste alto.

---


| Campo             | Tipo           | Descripción                        |
|-------------------|----------------|------------------------------------|
| `id`              | INT (PK, AI)   | ID del perfil                      |
| `idUsuario`       | INT            | Referencia al usuario              |
| `nombre`          | VARCHAR(100)   | Nombre                            |
| `apellidoPaterno` | VARCHAR(100)   | Apellido paterno                  |
| `apellidoMaterno` | VARCHAR(100)   | Apellido materno                  |
| `fechaNacimiento` | DATE           | Fecha de nacimiento               |
| `estado`          | VARCHAR(100)   | Estado de residencia              |
| `municipio`       | VARCHAR(100)   | Municipio                         |
| `localidad`       | VARCHAR(100)   | Localidad                         |
| `idiomaPreferido` | ENUM           | 'es', 'nah', 'en'                 |
| `tamLetra`        | ENUM           | 'chico', 'mediano', 'grande'      |
| `velocidadAudio`  | ENUM           | 'lento', 'normal', 'rapido'       |
| `contrasteAlto`   | BOOLEAN        | Modo de contraste alto            |
| `created_at`, `updated_at`, `deleted_at` | DATETIME | Campos estándar CI4 |

---

### 3. `cursos`
Cursos disponibles en la plataforma, multilingües y con portadas personalizadas.

| Campo               | Tipo         | Descripción                          |
|---------------------|--------------|--------------------------------------|
| `id`                | INT (PK, AI) | ID del curso                         |
| `titulo`            | VARCHAR(150) | Título del curso                     |
| `descripcion`       | TEXT         | Descripción general                  |
| `imagenPortada`     | VARCHAR(255) | Ruta de imagen                       |
| `idiomasDisponibles`| SET          | Idiomas disponibles ('es','nah','en')|
| `fechaCreacion`     | DATETIME     | Fecha de creación del curso          |
| `created_at`, `updated_at`, `deleted_at` | DATETIME | Campos estándar CI4 |

---

### 4. `modulos`
Módulos que componen cada curso.

| Campo      | Tipo         | Descripción                        |
|------------|--------------|------------------------------------|
| `id`       | INT (PK, AI) | ID del módulo                      |
| `idCurso`  | INT          | Referencia al curso                |
| `titulo`   | VARCHAR(150) | Título del módulo                  |
| `descripcion` | TEXT      | Descripción                        |
| `orden`    | INT          | Posición en la secuencia           |
| `created_at`, `updated_at`, `deleted_at` | DATETIME | Campos estándar CI4 |

---

### 5. `contenidos`
Contenido multimedia y textual de cada módulo.

| Campo          | Tipo         | Descripción                          |
|----------------|--------------|--------------------------------------|
| `id`           | INT (PK, AI) | ID del contenido                     |
| `idModulo`     | INT          | Módulo al que pertenece              |
| `tipo`         | ENUM         | 'video', 'audio', 'texto', 'interactivo' |
| `urlArchivo`   | TEXT         | Ruta o enlace del contenido          |
| `textoAdicional` | TEXT       | Descripción o ayuda extra            |
| `duracionEstimada` | INT      | En minutos                           |
| `created_at`, `updated_at`, `deleted_at` | DATETIME | Campos estándar CI4 |

---

### 6. `progreso`
Progreso individual por módulo.

| Campo         | Tipo         | Descripción                  |
|---------------|--------------|------------------------------|
| `id`          | INT (PK, AI) | ID del registro              |
| `idUsuario`   | INT          | Usuario que progresa         |
| `idModulo`    | INT          | Módulo completado o no       |
| `completado`  | BOOLEAN      | TRUE/FALSE                   |
| `fechaCompletado` | DATETIME | Fecha de finalización        |
| `created_at`, `updated_at`, `deleted_at` | DATETIME | Campos estándar CI4 |

---

### 7. `preguntas`
Preguntas para evaluaciones de cada módulo (tipo opción múltiple).

| Campo              | Tipo         | Descripción                          |
|--------------------|--------------|--------------------------------------|
| `id`               | INT (PK, AI) | ID de la pregunta                    |
| `idModulo`         | INT          | Módulo asociado                      |
| `pregunta`         | TEXT         | Enunciado                            |
| `opcion1`          | TEXT         | Primera opción                       |
| `opcion2`          | TEXT         | Segunda opción                       |
| `opcion3`          | TEXT         | Tercera opción                       |
| `respuestaCorrecta`| INT          | 1, 2 o 3 según la opción correcta     |
| `created_at`, `updated_at`, `deleted_at` | DATETIME | Campos estándar CI4 |

---

### 8. `respuestasUsuario`
Respuestas que cada usuario da a las preguntas de evaluación.

| Campo         | Tipo         | Descripción                        |
|---------------|--------------|------------------------------------|
| `id`          | INT (PK, AI) | ID del registro                    |
| `idUsuario`   | INT          | Usuario que responde               |
| `idPregunta`  | INT          | Pregunta respondida                |
| `respuesta`   | TEXT         | Texto de la respuesta              |
| `esCorrecta`  | BOOLEAN      | TRUE si la respuesta fue correcta  |
| `fechaRespuesta` | DATETIME  | Fecha de la respuesta              |
| `created_at`, `updated_at`, `deleted_at` | DATETIME | Campos estándar CI4 |

---

##  Notas técnicas
-  **No se utilizan claves foráneas** en esta etapa para facilitar el desarrollo rápido y desacoplado con CodeIgniter 4.
-  Cada tabla está preparada para `useSoftDeletes` y `useTimestamps` en los modelos de CI4.
-  Todos los módulos están pensados para una interfaz **responsiva** (móvil + web).

---

¿Deseas que te lo exporte como archivo `README.md` o te lo deje preparado como plantilla para GitHub o GitLab? También puedo generar el esquema de los modelos `CI4` en el siguiente paso.
