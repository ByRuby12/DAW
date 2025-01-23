<template>
  <div class="celda-organizador" @dragover.prevent="" @drop="dropTask(store.idSelec, store.tituloSelec, props.fecha, store.horaSelec, store.tiposSelec, store.descripcionSelec)">
    <a v-if="props.fecha !== ' ' && props.fecha !== null" @click.prevent="addTask()" href="#">
      <img src="../assets/img/agregar.png" class="add-icon">
    </a>
    <p :class="{ 'hoy': props.fecha === formattedDate }" class="fecha">{{ props.fecha }}</p>
    <miTarea v-for="task in tasksFilteredByDate" :key="task.id" :id="task.id" :titulo="task.titulo" :tipo="task.tipo" :fecha="task.fecha" :hora="task.hora" :descripcion="task.descripcion" />
  </div>
</template>

<style scoped>
.hoy {
    color: white;
    font-weight: bold;
    background-color: rgb(242, 0, 255);
    border-radius: 4px;
 }
.celda-organizador {
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 5px;
  position: relative;
  transition: background-color 0.3s ease;
  text-align: center; /* Centra el contenido horizontalmente */
}

.celda-organizador:hover {
  background-color: #f0f0f0;
}

.add-icon {
  width: 25px; /* Tamaño ligeramente más grande */
  height: 25px; /* Tamaño ligeramente más grande */
  margin-bottom: 10px;
}

.fecha {
  font-size: 18px; /* Tamaño de fuente más grande */
  font-weight: bold;
  margin: 0 auto; /* Centra la fecha horizontalmente */
}

.today {
  font-weight: bold;
  color: #000000;
}
</style>

<script setup lang="ts">
import { ref, onMounted, computed } from 'vue';
import { useSemaforoModalStore } from '@/stores/gestorModal';
import { obtenerTareas, actualizarTarea } from '@/axios/gestorTareas';
import type { Tarea } from '@/axios/gestorTareas';
import miTarea from './itemTarea.vue';

interface Props {
  fecha: string;
}

const props = defineProps<Props>();
const tasks = ref<Tarea[]>([]);
const store = useSemaforoModalStore();
const formattedDate: string = new Date().toLocaleDateString();

const dropTask = async (id: string, titulo: string, fecha: string, hora: string, tipo: string, descripcion: string): Promise<void> => {
  try {
    const editedTask = await actualizarTarea(id, titulo, fecha, hora, tipo, descripcion);
    if (editedTask) {
      document.location.reload();
    }
  } catch (error) {
    alert(`No se pudo mover la tarea ${titulo}`);
    console.error(error);
  }
};

// Se ejecuta cuando el componente se monta en el DOM
onMounted(async () => {
  try {
    const recoveredTasks = await obtenerTareas(); 
    // Actualiza el valor de las tareas en el store con las tareas recuperadas
    tasks.value = recoveredTasks;
  } catch (error) {
    console.error(error);
  }
});

//esto es para agregar una tarea nueva en la fecha seleccionada en el calendario
const addTask = () => {
  store.estadoCreate(true);
  store.fechaTake(props.fecha);
};

//Filtra las tareas por fecha
const tasksFilteredByDate = computed(() => tasks.value.filter(task => task.fecha === props.fecha));
</script>
