<template>
  <form class="formTarea" @submit.prevent="agregarTarea">
    <div class="form-group">
      <h2>NUEVA TAREA</h2>
      <hr>
      <label for="titulo">TITULO:</label>
      <input type="text" id="titulo" v-model="titulo" required>
      <label for="fecha">FECHA (Ejemplo: 12/3/2024):</label>
      <input type="text" id="fecha" v-model="fecha" required>
      <label for="hora">HORA DE INICIO:</label>
      <input type="time" id="hora" v-model="hora" required>
      <label for="tipo">TIPO DE TAREA:</label>
      <select id="tipo" v-model="tipo" required>
          <option value="Conferencia">Conferencia</option>
          <option value="Evento">Evento</option>
          <option value="Examen">Examen</option>
          <option value="Cumpleaños">Cumpleaños</option>
          <option value="Reunion">Reunion</option>
          <option value="OtroEvento">Otro</option>
      </select>
      <label for="descripcion">DETALLES DE LA TAREA:</label>
      <textarea id="descripcion" v-model="descripcion" required></textarea>
    </div>
    <div class="form-group mt-2">
      <button type="submit" class="btn btn-primary">Agregar Tarea</button>
      <button class="btn btn-danger ml-2" @click.prevent="cancelarAgregar">Cancelar</button>
    </div>
  </form>
</template>

<style scoped>
/* Estilos generales */
.formTarea {
  font-family: 'Roboto', sans-serif; /* Tipografía principal */
  background-color: #fff; /* Fondo blanco */
  border: 1px solid #ccc; /* Borde gris */
  border-radius: 10px; /* Bordes redondeados */
  padding: 30px; /* Espaciado interno */
  box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); /* Sombra suave */
  transition: transform 0.3s ease; /* Transición suave */
}

.formTarea:hover {
  transform: translateY(-5px); /* Efecto de elevación al pasar el ratón */
}

.form-group {
  margin-bottom: 20px; /* Espaciado inferior */
}

h2 {
  font-size: 28px; /* Tamaño de fuente grande */
  color: #007bff; /* Azul */
  margin-bottom: 20px; /* Espaciado inferior */
}

hr {
  border-color: #007bff; /* Línea divisoria azul */
  margin-bottom: 30px; /* Espaciado inferior */
}

label {
  font-size: 18px; /* Tamaño de fuente grande */
  color: #333; /* Texto negro */
}

input[type="text"],
select,
textarea {
  width: 100%; /* Ancho completo */
  padding: 12px; /* Espaciado interno */
  border: 1px solid #ccc; /* Borde gris */
  border-radius: 5px; /* Bordes redondeados */
  box-sizing: border-box; /* Incluir borde y relleno en el ancho */
  font-size: 16px; /* Tamaño de fuente grande */
  margin-bottom: 20px; /* Espaciado inferior */
}

input[type="date"],
input[type="time"] {
  appearance: none; /* Eliminar apariencia nativa */
  -webkit-appearance: none; /* Para navegadores webkit */
  -moz-appearance: none; /* Para navegadores Firefox */
  width: 100%; /* Ancho completo */
  padding: 12px; /* Espaciado interno */
  border: 1px solid #ccc; /* Borde gris */
  border-radius: 5px; /* Bordes redondeados */
  box-sizing: border-box; /* Incluir borde y relleno en el ancho */
  font-size: 16px; /* Tamaño de fuente grande */
  margin-bottom: 20px; /* Espaciado inferior */
}

textarea {
  resize: none; /* Evitar redimensionamiento */
}

.btn {
  padding: 15px 30px; /* Espaciado interno */
  font-size: 18px; /* Tamaño de fuente grande */
  border: none; /* Sin borde */
  border-radius: 5px; /* Bordes redondeados */
  cursor: pointer; /* Cambiar cursor al pasar por encima */
  transition: background-color 0.3s ease; /* Transición suave */
}

.btn-primary {
  background-color: #007bff; /* Azul */
  color: #fff; /* Texto blanco */
}

.btn-danger {
  background-color: #dc3545; /* Rojo */
  color: #fff; /* Texto blanco */
}

.btn-primary:hover, .btn-danger:hover {
  background-color: #0056b3; /* Azul oscuro al pasar el ratón */
}

</style>


<script setup lang="ts">
import { ref } from 'vue';
import { crearTarea } from '@/axios/gestorTareas';
import { useSemaforoModalStore } from '@/stores/gestorModal';

const store = useSemaforoModalStore();

const titulo = ref<string>('');
const fecha = ref<string>('');
const hora = ref<string>('');
const tipo = ref<string>('');
const descripcion = ref<string>('');

const agregarTarea = async () => {
  try {
    const newTask = await crearTarea(generarId(), titulo.value, fecha.value, hora.value, tipo.value, descripcion.value);
    if (newTask) {
      alert('Has Ingresado Correctamente La Tarea al Calendario');
      store.estadoCreate(false);
      document.location.reload();
    }
  } catch (error) {
    alert('Algo ha salido mal');
    console.error(error);
  }
};

const cancelarAgregar = () => {
  store.estadoCreate(false);
};

const generarId = () => {
  return '_' + Math.random().toString(36).substr(2, 9);
};
</script>
