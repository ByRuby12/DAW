<template>
  <div class="calendario-container">
    <table class="calendario-table">
      <thead>
        <tr>
          <th v-for="day in daysOfWeek" :key="day" class="day-header">{{ day }}</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(week, index) in weeks" :key="index">
          <td v-for="day in week" :key="day" class="day-cell">
            <celdaCalendario :fecha="day" class="celda-calendario" />
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<style scoped>
/* Estilos generales */
.calendario-container {
  font-family: Arial, sans-serif;
}

.calendario-table {
  width: 100%;
  border-collapse: collapse;
  border: 2px solid black; /* Borde de la tabla */
}

.day-header {
  background-color: #28a745; /* Verde */
  color: black; /* Letras negras */
  padding: 10px;
}

.day-cell {
  border: 1px solid black; /* Borde negro */
  padding: 10px;
  text-align: center;
}

/* Estilos para el componente CeldaCalendario */
.celda-calendario {
  /* Estilos específicos para las celdas del calendario */
  background-color: white; /* Fondo blanco */
  border: 1px solid #ced4da;
  padding: 5px;
  cursor: pointer;
  transition: background-color 0.3s ease; /* Transición para el cambio de color */
  display: block; /* Cambio de comportamiento para ocupar toda la celda */
}

.celda-calendario:hover {
  background-color: #f8f9fa; /* Gris */
}

.celda-calendario:hover .tarea {
  background-color: #ddd; /* Hover de la celda de las tareas */
}

.celda-calendario .tarea:hover {
  background-color: #ccc; /* Hover de las celdas de las tareas */
}
</style>


<script setup lang="ts">
import { computed } from 'vue';
import celdaCalendario from '@/components/celdaOrganizador.vue';

interface Props {
  mes?: number;
  anio?: number;
  cols?: string[];
  COLS?: number;
  ROWS?: number;
}

const props = withDefaults(defineProps<Props>(), {
  cols: () => ['LUNES', 'MARTES', 'MIERCOLES', 'JUEVES', 'VIERNES', 'SABADO', 'DOMINGO'],
  COLS: 7,
  ROWS: 5,
  anio: 2000,
  mes: 1
});

const daysOfWeek = computed(() => props.cols);

const weeks = computed(() => {
  const celdas: string[][] = Array.from(Array(props.COLS).keys()).map(() =>
    Array.from(Array(props.ROWS).keys()).map(() => ' ')
  );
  const firstDay = new Date(`${props.anio}-${props.mes}-1`);
  const firstDayIndex = [6, 0, 1, 2, 3, 4, 5][firstDay.getDay()];
  const daysInMonth = new Date(props.anio, props.mes, 0).getDate();
  const dayNumbers = [...Array(daysInMonth).keys()].map(i => i + firstDayIndex);
  dayNumbers.forEach((el, ind) => addSequentialValue(el, `${ind + 1}/${props.mes}/${props.anio}`, celdas));
  return celdas;
});

// Calcula la fila y la columna en base al número dado y las columnas del componente.
const addSequentialValue = (number: number, value: string, cells: string[][]) => {
  let row = Math.floor(number / daysOfWeek.value.length);
  let column = number % daysOfWeek.value.length;
  cells[row][column] = value;
};
</script>

