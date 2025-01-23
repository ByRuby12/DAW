<script setup lang="ts">
import { eliminarTarea } from '@/axios/gestorTareas';
import { useSemaforoModalStore } from '@/stores/gestorModal';

const store = useSemaforoModalStore();

interface Props {
    tipo: string;
    titulo: string;
    id: string;
    fecha: string;
    hora: string;
    descripcion: string;
}

const props  = defineProps<Props>();

const accionEliminar = async (id: string) => {
    try {
        const tareaEliminada = await eliminarTarea(id);
        if (tareaEliminada) {
            alert(`Has Eliminado la Tarea`);
            document.location.reload();
        }
    } catch (e) {
        alert(`Algo ha Salido mal`);
        console.error(e);
    }
};

const accionVer = () => {
    guardarDatos();
    store.estadoVer(true);
};

const accionEditar = () => {
    guardarDatos();
    store.estadoEdit(true);
};

const iniciarArrastre = () => {
    guardarDatos();
};

const guardarDatos = () => {
    store.idTake (props.id);
    store.tituloTake (props.titulo);
    store.fechaTake (props.fecha);
    store.horaTake (props.hora);
    store.tipoTake (props.tipo);
    store.descripcionTake(props.descripcion);
};
</script>

<template>
  <div class="item-tarea" draggable="true" @dragstart="iniciarArrastre()">
    <p class="tipo-tarea">{{ props.tipo }}</p>
    <div class="icon-group">
      <a href="#" @click.prevent="accionVer()">
        <img class="icon" src="../assets/img/vista.png">
      </a>
      <a href="#" @click.prevent="accionEditar()">
        <img class="icon" src="../assets/img/editar.png">
      </a>
      <a href="#" @click.prevent="accionEliminar(props.id)">
        <img class="icon" src="../assets/img/borrar.png">
      </a>
    </div>
  </div>
</template>

<style scoped>
.item-tarea {
  display: flex;
  justify-content: space-between; /* Distribuye el contenido de forma equitativa */
  align-items: center; /* Alinea los elementos verticalmente */
  gap: 3px;
  border: 1px solid #ccc;
  border-radius: 5px;
  padding: 5px;
  transition: border-color 0.3s ease;
}

.item-tarea:hover {
  background-color: #b9b9b9;
}

.tipo-tarea {
  font-size: 15px; /* Tamaño de fuente más grande */
  color: rgb(0, 0, 0);
  font-weight: bold;
}

.icon-group {
  display: flex;
  align-items: center;
}

.icon {
  width: 20px;
  height: 20px;
  margin-left: 5px; /* Añade un pequeño margen entre los iconos */
}
</style>
