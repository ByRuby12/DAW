import {
    saveData,
    deleteData,
    getDataCollection,
    updateData,
    deleteField
} from "../firebase/firebase.js";

document.addEventListener('DOMContentLoaded', () => {
    // Cargar zonas iniciales
    loadZones();

    // Evento para añadir nueva zona
    document.getElementById('addZoneBtn').addEventListener('click', async () => {
        const zoneName = prompt('Introduce el nombre de la nueva zona:');
        if (zoneName) {
            const newZone = { name: zoneName };
            await saveData('zones', newZone);
            loadZones();
        }
    });
});

async function loadZones() {
    const zonesContainer = document.getElementById('zonesContainer');
    zonesContainer.innerHTML = '';

    const zonesSnapshot = await getDataCollection('zones');
    zonesSnapshot.forEach((zoneDoc) => {
        const zoneData = zoneDoc.data();
        const zoneId = zoneDoc.id;

        const zoneElement = document.createElement('div');
        zoneElement.classList.add('zone');

        const zoneHeader = document.createElement('div');
        zoneHeader.classList.add('zone-header');

        zoneHeader.innerHTML = `<h2>${zoneData.name}</h2>`;

        zoneElement.appendChild(zoneHeader);

        // Contenedor para sensores
        const sensorsContainer = document.createElement('div');
        sensorsContainer.classList.add('sensors-container');

        // Mostrar cada sensor con su propio enlace de modificar
        for (const field in zoneData) {
            if (field !== 'name' && field !== 'executors') {
                const sensorContainer = document.createElement('div');
                sensorContainer.classList.add('sensor-container');

                sensorContainer.innerHTML = `
                    <p>Sensor ${field}: ${zoneData[field]}% </p>
                    <button onclick="openModifyPage('sensor', '${zoneId}', '${field}')" class="modify-sensor-btn">Modificar Sensor</button>
                    <button onclick="deleteSensor('${zoneId}', '${field}')" class="delete-sensor-btn">Borrar Sensor</button>
                `;

                sensorsContainer.appendChild(sensorContainer);
            }
        }

        zoneElement.appendChild(sensorsContainer);

        // Contenedor para ejecutores
        const executorsContainer = document.createElement('div');
        executorsContainer.classList.add('executors-container');

        // Mostrar cada executor con su propio enlace de modificar
        for (const executor in zoneData.executors) {
            const executorContainer = document.createElement('div');
            executorContainer.classList.add('executor-container');

            executorContainer.innerHTML = `
                <p>Ejecutor ${executor}: ${zoneData.executors[executor] ? 'Activado' : 'Desactivado'}</p>
                <button onclick="openModifyPage('executor', '${zoneId}', '${executor}')" class="modify-sensor-btn">Modificar Executor</button>
                <button onclick="deleteExecutor('${zoneId}', '${executor}')" class="delete-executor-btn">Borrar Executor</button>
            `;

            executorsContainer.appendChild(executorContainer);
        }

        zoneElement.appendChild(executorsContainer);

        // Botón para agregar nuevos sensores
        const addSensorButton = document.createElement('button');
        addSensorButton.textContent = 'Agregar Nuevo Sensor';
        addSensorButton.onclick = () => addNewSensor(zoneId);
        addSensorButton.classList.add('add-sensor-btn');

        zoneElement.appendChild(addSensorButton);

        // Botón para agregar nuevos ejecutores
        const addExecutorButton = document.createElement('button');
        addExecutorButton.textContent = 'Agregar Nuevo Executor';
        addExecutorButton.onclick = () => addNewExecutor(zoneId);
        addExecutorButton.classList.add('add-executor-btn');

        zoneElement.appendChild(addExecutorButton);

        // Botón para modificar el nombre de la zona
        const modifyZoneNameButton = document.createElement('button');
        modifyZoneNameButton.textContent = 'Modificar Nombre de Zona';
        modifyZoneNameButton.onclick = () => modifyZoneName(zoneId, zoneData.name);
        modifyZoneNameButton.classList.add('modify-zone-name-btn');

        zoneElement.appendChild(modifyZoneNameButton);

        // Botón para borrar la zona
        const deleteZoneButton = document.createElement('button');
        deleteZoneButton.textContent = 'Borrar Zona';
        deleteZoneButton.onclick = () => deleteZone(zoneId);
        deleteZoneButton.classList.add('delete-zone-btn');

        zoneElement.appendChild(deleteZoneButton);

        zonesContainer.appendChild(zoneElement);
    });
}


/*--------------------------------------------------------------*/

window.openModifyPage = function (type, zoneId, name) {
    const modifyPageUrl = `../../IOT-Modify/vista/modify.html?type=${type}&zoneId=${zoneId}&${type}Name=${name}`;
    window.open(modifyPageUrl, 'height=400,width=400');
}

window.addEventListener('message', (event) => {
    if (event.data.action === 'updateZone') {
        loadZones();
    }
});

/*--------------------------------------------------------------*/

window.deleteZone = async function (zoneId) {
    const confirmDelete = confirm('¿Seguro que quieres borrar esta zona?');
    if (confirmDelete) {
        await deleteData(zoneId, 'zones');
        loadZones(); // Actualizar la pantalla después de borrar
    }
}

window.modifyZoneName = async function (zoneId, currentName) {
    const newZoneName = prompt('Introduce el nuevo nombre de la zona:', currentName);
    if (newZoneName && newZoneName !== currentName) {
        const updatedData = {
            name: newZoneName,
        };

        await updateData(zoneId, 'zones', updatedData);
        loadZones();
    }
}

/*--------------------------------------------------------------*/

window.addNewExecutor = async function (zoneId) {
    const executorName = prompt('Introduce el nombre del nuevo executor:');
    if (executorName) {
        const activateExecutor = confirm(`¿Activar el Executor "${executorName}"?`);

        const updatedData = {
            [`executors.${executorName}`]: activateExecutor,
        };

        await updateData(zoneId, 'zones', updatedData);
        loadZones();
    }
}

window.updateExecutor = async function (zoneId, executorName) {
    const activateExecutor = confirm(`¿Activar el Executor "${executorName}"?`);

    if (activateExecutor !== null) {
        const updatedData = {
            [`executors.${executorName}`]: activateExecutor,
        };

        await updateData(zoneId, 'zones', updatedData);
        loadZones();
    }
}

window.deleteExecutor = async function (zoneId, executorName) {
    const confirmDelete = confirm(`¿Seguro que quieres borrar el ejecutor "${executorName}" de la zona?`);
    if (confirmDelete) {
        // Utiliza la función deleteField del módulo CRUD para borrar el ejecutor
        await deleteField(zoneId, 'zones', `executors.${executorName}`);
        loadZones();
    }
}

/*--------------------------------------------------------------*/

window.updateSensor = async function (zoneId, sensorName) {
    const newValue = prompt(`Introduce el nuevo valor para el sensor ${sensorName}:`);

    if (newValue !== null) {
        const updatedData = {
            [sensorName]: parseInt(newValue) || 0,
        };

        await updateData(zoneId, 'zones', updatedData);
        loadZones();
    }
}

window.addNewSensor = async function (zoneId) {
    const sensorName = prompt('Introduce el nombre del nuevo sensor:');

    if (sensorName) {
        const newValue = prompt(`Introduce el valor inicial para el nuevo sensor ${sensorName}`);

        if (newValue !== null) {
            const updatedData = {
                [sensorName]: parseInt(newValue) || 0,
            };

            await updateData(zoneId, 'zones', updatedData);
            loadZones();
        }
    }
}

window.deleteSensor = async function (zoneId, sensorName) {
    const confirmDelete = confirm(`¿Seguro que quieres borrar el sensor "${sensorName}" de la zona?`);
    if (confirmDelete) {
        await deleteField(zoneId, 'zones', sensorName);
        loadZones(); 
    }
}

/*--------------------------------------------------------------*/