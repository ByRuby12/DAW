const formulario = document.getElementById('formulario');
const seleccionados = document.getElementById('seleccionados');
const delegado = document.getElementById('delegado');
const subdelegado = document.getElementById('subDelegado');
const numVotos = document.getElementById('numVotos');
const grabarButton = document.getElementById('grabar');
const eliminarButton = document.getElementById('eliminar');

const control = {
  listaVotados: [],
  votosEmitidos: 0,

  cargarDatosGuardados() {
    const datosGuardados = JSON.parse(localStorage.getItem('datosVotacion'));
    if (datosGuardados) {
      this.listaVotados = datosGuardados.listaVotados;
      this.votosEmitidos = datosGuardados.votosEmitidos;
      this.actualizarUI();
    }
  },

  guardarDatos() {
    const datosVotacion = {
      listaVotados: this.listaVotados,
      votosEmitidos: this.votosEmitidos,
    };
    localStorage.setItem('datosVotacion', JSON.stringify(datosVotacion));
  },

  aumentaVoto(id) {
    this.listaVotados[id].votos++;
    this.votosEmitidos++;
    numVotos.textContent = this.votosEmitidos;
    this.guardarDatos();
  },

  insertaVotado(nombre) {
    this.listaVotados.push({
      nombre: nombre,
      votos: 0,
    });
    const id = this.listaVotados.length - 1;

    const elementoListaSeleccionados = document.createElement('div');
    elementoListaSeleccionados.innerHTML = `<p>${nombre}</p>
      <input type="button" class="boton-modificado" value="0" id="C${id}" data-counter>`;

    elementoListaSeleccionados.id = nombre;
    seleccionados.append(elementoListaSeleccionados);

    document.getElementById(`C${id}`).addEventListener('click', (event) => {
      if (event.target.dataset.counter != undefined) {
        this.aumentaVoto(id);
        event.target.value++;
        this.dameDelegado();
        formulario['nombre'].focus();
      }
    });
    this.guardarDatos();
  },

  reseteaFormulario() {
    formulario['nombre'].value = '';
    formulario['nombre'].focus();
  },

  dameDelegado() {
    const nombreDelegado = [...this.listaVotados].sort((ele1, ele2) => ele2.votos - ele1.votos);
    delegado.textContent = `Delegado: ${nombreDelegado[0].nombre}`;
    const divDelegado = document.getElementById(`${nombreDelegado[0].nombre}`);
    seleccionados.insertAdjacentElement('afterbegin', divDelegado);
    if (nombreDelegado.length > 1) {
      subdelegado.textContent = `SubDelegado: ${nombreDelegado[1].nombre}`;
      const divSubDelegado = document.getElementById(`${nombreDelegado[1].nombre}`);
      divDelegado.insertAdjacentElement('afterend', divSubDelegado);
    }
  },

  eliminarDatos() {
    localStorage.removeItem('datosVotacion');
    this.listaVotados = [];
    this.votosEmitidos = 0;
    seleccionados.innerHTML = '';
    numVotos.textContent = '0';
    delegado.textContent = '';
    subdelegado.textContent = '';
    this.reseteaFormulario();
  },

  actualizarUI() {
    this.listaVotados.forEach((votado, id) => {
      const elementoListaSeleccionados = document.createElement('div');
      elementoListaSeleccionados.innerHTML = `<p>${votado.nombre}</p>
      <input type="button" class="boton-modificado" value="${votado.votos}" id="C${id}" data-counter>`;
      elementoListaSeleccionados.id = votado.nombre;
      seleccionados.append(elementoListaSeleccionados);
      document.getElementById(`C${id}`).addEventListener('click', (event) => {
        if (event.target.dataset.counter != undefined) {
          this.aumentaVoto(id);
          event.target.value++;
          this.dameDelegado();
          formulario['nombre'].focus();
        }
      });
    });
    numVotos.textContent = this.votosEmitidos;
    this.dameDelegado();
  },
};

control.cargarDatosGuardados();

grabarButton.addEventListener('click', () => {
  control.guardarDatos();
  alert('¡Datos guardados correctamente!');
});

eliminarButton.addEventListener('click', () => {
  control.eliminarDatos();
  alert('¡Datos eliminados correctamente!');
});

formulario.addEventListener('submit', (event) => {
  event.preventDefault();
  if (formulario['nombre'].value !== '') {
    control.insertaVotado(formulario['nombre'].value);
    control.reseteaFormulario();
  }
});
