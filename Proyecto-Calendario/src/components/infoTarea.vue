<template>
  <form class="form-tarea">
    <div class="form-container">
      <h2 class="titulo">NOMBRE:{{ props.nombre }}</h2>
      <hr>
      <table class="detalle-table">
        <tbody>
          <tr>
            <td class="campo">FECHA:</td>
            <td class="valor">{{ props.fecha }}</td>
          </tr>
          <tr>
            <td class="campo">HORA DE INICIO DEL EVENTO:</td>
            <td class="valor">{{ props.hora }}</td>
          </tr>
          <tr>
            <td class="campo">TIPO DE TAREA DEL EVENTO:</td>
            <td class="valor">{{ props.tipo }}</td>
          </tr>
          <tr>
            <td class="campo">DETALLES DEL EVENTO:</td>
            <td class="valor">{{ props.descripcion }}</td>
          </tr>
        </tbody>
      </table>
      <div class="button-group">
        <button class="btn btn-danger" @click.prevent="atras">Volver</button>
      </div>
    </div>
  </form>
</template>

<style scoped>
.form-tarea {
  display: flex;
  justify-content: center;
  align-items: center;
  width: 100%;
}

.form-container {
  width: 90%;
  max-width: 800px;
  background-color: #f0f0f0;
  padding: 40px;
  border-radius: 20px;
  box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
}

.titulo {
  font-size: 36px;
  color: #333;
  text-align: center;
  margin-bottom: 20px;
}

.detalle-table {
  width: 100%;
  border-collapse: collapse;
}

.campo,
.valor {
  padding: 10px;
  border-bottom: 1px solid #ccc;
}

.campo {
  font-weight: bold;
  color: #007bff;
}

.button-group {
  display: flex;
  justify-content: center;
}

.btn {
  padding: 15px 30px;
  border-radius: 10px;
  cursor: pointer;
  font-size: 24px;
  font-weight: bold;
  transition: all 0.3s ease;
  background-color: #dc3545;
  color: #fff;
  border: none;
}

.btn:hover {
  transform: scale(1.05);
}
</style>



<script setup lang="ts">
import { useSemaforoModalStore } from '@/stores/gestorModal';

const store = useSemaforoModalStore();

interface Props {
  nombre: string;
  fecha: string;
  hora: string;
  tipo: string;
  descripcion: string;
}

const props  = defineProps<Props>();

const atras = () => {
  store.estadoVer(false);
};
</script>
