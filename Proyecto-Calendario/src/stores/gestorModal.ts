import { defineStore } from 'pinia';
import { ref, computed } from 'vue';
import type { ComputedRef, Ref } from 'vue';

interface ModalState {
  creando: Ref<boolean>;
  viendo: Ref<boolean>;
  editando: Ref<boolean>;
  fecha: Ref<string | undefined>;
  titulo: Ref<string | undefined>;
  hora: Ref<string | undefined>;
  tipo: Ref<string | undefined>;
  descripcion: Ref<string | undefined>;
  id: Ref<string | undefined>;
}

// Define y tipa el store 
export const useSemaforoModalStore = defineStore('semaforo', () => {
  // Declaración de estado reactiva
  const modalState: ModalState = {
    creando: ref(false),
    viendo: ref(false),
    editando: ref(false),
    fecha: ref(),
    titulo: ref(),
    hora: ref(),
    tipo: ref(),
    descripcion: ref(),
    id: ref(),
  };

  const estadoVer = (valor: boolean) => {
    modalState.viendo.value = valor;
  };

  const estadoEdit = (valor: boolean) => {
    modalState.editando.value = valor;
  };

  const cogerDato = (prop: keyof ModalState, valor: string | undefined) => {
    modalState[prop].value = valor;
  };

  const estadoCreate = (valor: boolean) => {
    modalState.creando.value = valor;
  };

  //la parte de getters del calendario 
  const paraVer: ComputedRef<boolean> = computed(() => modalState.viendo.value);
  const paraEditar: ComputedRef<boolean> = computed(() => modalState.editando.value);
  const fechaSelec: ComputedRef<string | undefined> = computed(() => modalState.fecha.value);
  const tituloSelec: ComputedRef<string | undefined> = computed(() => modalState.titulo.value);
  const paraCrear: ComputedRef<boolean> = computed(() => modalState.creando.value);
  const horaSelec: ComputedRef<string | undefined> = computed(() => modalState.hora.value);
  const tiposSelec: ComputedRef<string | undefined> = computed(() => modalState.tipo.value);
  const descripcionSelec: ComputedRef<string | undefined> = computed(() => modalState.descripcion.value);
  const idSelec: ComputedRef<string | undefined> = computed(() => modalState.id.value);

  //valores de eventos calendario
  const fechaTake = (valor: string | undefined) => cogerDato('fecha', valor);
  const tituloTake = (valor: string | undefined) => cogerDato('titulo', valor);
  const horaTake = (valor: string | undefined) => cogerDato('hora', valor);
  const tipoTake = (valor: string | undefined) => cogerDato('tipo', valor);
  const descripcionTake = (valor: string | undefined) => cogerDato('descripcion', valor);
  const idTake = (valor: string | undefined) => cogerDato('id', valor);

  return {
    paraVer, paraEditar, paraCrear, fechaSelec, tituloSelec, horaSelec, tiposSelec, descripcionSelec, idSelec,
    estadoCreate, estadoVer, estadoEdit, fechaTake, tituloTake, horaTake, descripcionTake, tipoTake, idTake
    };
});
