<template>
  <form class="form-tarea" @submit.prevent="editarTarea">
    <div class="form-container">
      <h2 class="form-title">Editar Evento</h2>
      <div class="form-group">
        <label for="titulo" class="form-label">Título:</label>
        <input type="text" id="titulo" v-model="titulo" class="form-input" required>
      </div>
      <div class="form-group">
        <label for="fecha" class="form-label">Fecha:</label>
        <input type="text" id="fecha" v-model="fecha" class="form-input" required>
      </div>
      <div class="form-group">
        <label for="hora" class="form-label">Hora de inicio:</label>
        <input type="text" id="hora" v-model="hora" class="form-input" required>
      </div>
      <div class="form-group">
        <label for="tipo" class="form-label">Tipo de evento:</label>
        <select id="tipo" v-model="tipo" class="form-select" required>
          <option value="Conferencia">Conferencia</option>
          <option value="Evento">Evento</option>
          <option value="Examen">Examen</option>
          <option value="Cumpleaños">Cumpleaños</option>
          <option value="Reunion">Reunion</option>
          <option value="OtroEvento">Otro</option>
        </select>
      </div>
      <div class="form-group">
        <label for="descripcion" class="form-label">Detalles:</label>
        <textarea id="descripcion" v-model="descripcion" class="form-textarea" required></textarea>
      </div>
      <div class="button-group">
        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        <button class="btn btn-danger" @click.prevent="cancelarEdicion">Cancelar</button>
      </div>
    </div>
  </form>
</template>

<style scoped>
.form-tarea {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
}

.form-container {
  width: 80%;
  max-width: 600px;
  background-color: #f7f7f7;
  padding: 40px;
  border-radius: 20px;
  box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
}

.form-title {
  text-align: center;
  margin-bottom: 30px;
  font-size: 32px;
  color: #333;
}

.form-group {
  margin-bottom: 20px;
}

.form-label {
  display: block;
  margin-bottom: 10px;
  font-size: 24px;
  color: #555;
}

.form-input,
.form-select,
.form-textarea {
  width: 100%;
  padding: 15px;
  border: 2px solid #ccc;
  border-radius: 10px;
  font-size: 20px;
  color: #555;
}

.form-select {
  appearance: none;
  background-image: url('data:image/svg+xml;utf8,<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M17.25 9.75L12 15L6.75 9.75" stroke="%23555" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>');
  background-repeat: no-repeat;
  background-position: right 10px top 50%;
  background-size: 24px;
}

.form-textarea {
  resize: none;
}

.button-group {
  display: flex;
  justify-content: center;
  margin-top: 30px;
}

.btn {
  padding: 15px 30px;
  border-radius: 10px;
  cursor: pointer;
  font-size: 20px;
  font-weight: bold;
  transition: all 0.3s ease;
}

.btn-primary {
  background-color: #007bff;
  color: #fff;
  border: none;
}

.btn-danger {
  background-color: #dc3545;
  color: #fff;
  border: none;
}

.btn:hover {
  transform: scale(1.05);
}

.btn-primary:hover {
  background-color: #0056b3;
}

.btn-danger:hover {
  background-color: #c82333;
}
</style>


<script setup lang="ts">
import { ref } from 'vue';
import { actualizarTarea } from '@/axios/gestorTareas';
import { useSemaforoModalStore } from '@/stores/gestorModal';

const store = useSemaforoModalStore();

const titulo = ref<string>(store.tituloSelec || '');
const fecha = ref<string>(store.fechaSelec || '');
const hora = ref<string>(store.horaSelec || '');
const tipo = ref<string>(store.tiposSelec || '');
const descripcion = ref<string>(store.descripcionSelec || '');
const id = ref<string>(store.idSelec || '');

const editarTarea = async () => {
  try {
    const editedTask = await actualizarTarea(id.value, titulo.value, fecha.value, hora.value, tipo.value, descripcion.value);
    if (editedTask) {
      alert('Has Actualizado La Tarea del Calendario');
      store.estadoEdit(false);
      document.location.reload();
    }
  } catch (error) {
    alert('No se pudo actualizar la tarea.');
    console.error(error);
  }
};

const cancelarEdicion = () => {
  store.estadoEdit(false);
};
</script>
