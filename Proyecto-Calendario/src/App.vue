<template>
  <div class="modal-bg" v-if="store.paraCrear">
    <formCrearTarea :fecha="store.fechaSelec" />
  </div>

  <div class="modal-bg" v-if="store.paraEditar">
    <formEditarTarea
      :id="store.idSelec"
      :nombre="store.tituloSelec"
      :fecha="store.fechaSelec"
      :tipo="store.tiposSelec"
      :hora="store.horaSelec"
      :descripcion="store.descripcionSelec"
    />
  </div>

  <div class="modal-bg" v-if="store.paraVer">
    <formInfoTarea
      :nombre="store.tituloSelec"
      :fecha="store.fechaSelec"
      :hora="store.horaSelec"
      :tipo="store.tiposSelec"
      :descripcion="store.descripcionSelec"
    />
  </div>

  <div class="display-flex text-center">
    <div class="date-inputs">
      <label for="mes" class="date-label">Mes:</label>
      <input type="number" v-model="mes" min="1" max="12" id="mes" class="date-input" />
      <label for="anio" class="date-label">Año:</label>
      <input type="number" v-model="anio" min="2000" max="2050" id="anio" class="date-input" />
    </div>
    <br>
  </div>
  <calendarioMes :mes="mes" :anio="anio" />
</template>

<style scoped>
/* Estilo general */
.modal-bg {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5); /* Fondo semitransparente */
  display: flex;
  justify-content: center;
  align-items: center;
}

.display-flex {
  flex-direction: column;
  align-items: center;
}

.text-center {
  text-align: center;
}

h1 {
  font-size: 32px; /* Tamaño de la fuente aumentado */
  color: #333; /* Color de texto */
  font-family: Arial, sans-serif; /* Tipografía */
}

/* Estilo de los campos de entrada de fecha */
.date-inputs {
  display: flex;
  justify-content: center;
  align-items: center;
}

.date-label {
  font-size: 20px; /* Tamaño de la fuente aumentado */
  margin-right: 10px;
  font-family: Arial, sans-serif; /* Tipografía */
}

.date-input {
  padding: 12px; /* Aumento del tamaño del padding */
  border-radius: 8px; /* Aumento del radio de borde */
  border: 1px solid #ccc; /* Borde gris */
  font-size: 20px; /* Tamaño de la fuente aumentado */
  width: 120px; /* Aumento del ancho */
  font-family: Arial, sans-serif; /* Tipografía */
}

.date-input:hover,
.date-input:focus {
  border-color: #007bff; /* Borde azul al hacer hover o focus */
}

hr {
  width: 100%;
  margin: 20px 0;
  border: none;
  border-bottom: 1px solid #ccc; /* Línea horizontal gris */
}

/* Estilos para los modales */
.modal-content {
  background-color: white;
  padding: 20px;
  border-radius: 10px;
  box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.3); /* Sombra alrededor del modal */
}

/* Estilos para los botones en los modales */
.btn {
  padding: 12px 24px; /* Aumento del tamaño del padding */
  border-radius: 8px; /* Aumento del radio de borde */
  cursor: pointer;
  font-family: Arial, sans-serif; /* Tipografía */
}

.btn-primary {
  background-color: #007bff; /* Color de fondo azul */
  color: white;
}

.btn-primary:hover {
  background-color: #0056b3; /* Color de fondo azul oscuro al hacer hover */
}

.btn-danger {
  background-color: #dc3545; /* Color de fondo rojo */
  color: white;
}

.btn-danger:hover {
  background-color: #c82333; /* Color de fondo rojo oscuro al hacer hover */
}

  .modal-bg {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 9999;
    display: flex;
    align-items: center;
    justify-content: center;
  }
</style>

<script setup lang="ts">
    import calendarioMes from '@/components/calendarioOrganizador.vue';
    import formCrearTarea from '@/components/formNuevaTarea.vue';
    import formInfoTarea from '@/components/infoTarea.vue';
    import formEditarTarea from './components/formEditarEvento.vue';
    import { useSemaforoModalStore } from '@/stores/gestorModal';
    import { ref } from 'vue';
    
    const store = useSemaforoModalStore();
    const fechaActual = new Date();
    
    //De documentales de Vue
    const year = ref<number>(fechaActual.getFullYear());
    const month = ref<number>(fechaActual.getMonth() + 1);
    const mes = ref(month);
    const anio = ref(year);
</script>