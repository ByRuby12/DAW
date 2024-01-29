import {
    saveData,
    deleteData,
    getDataCollection,
    updateData
} from "./firebase.js"

document.addEventListener('DOMContentLoaded', () => {
    // Cargar zonas iniciales
    loadZones();

    // Evento para añadir nueva zona
    document.getElementById('addZoneBtn').addEventListener('click', async () => {
        const zoneName = prompt('Introduce el nombre de la nueva zona:');
        if (zoneName) {
            const newZone = { name: zoneName, Light: 0, Temperature: 0, Humidity: 0 };
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

        zoneElement.innerHTML = `<h2>${zoneData.name}</h2>`;

        // Crear un contenedor para los sensores
        const sensorsContainer = document.createElement('div');
        sensorsContainer.classList.add('sensors-container');

        // Mostrar cada sensor con su propio botón de modificar
        for (const field in zoneData) {
            if (field !== 'name') {
                const sensorContainer = document.createElement('div');
                sensorContainer.classList.add('sensor-container');

                sensorContainer.innerHTML = `
                    <p>${field}: ${zoneData[field]}</p>
                    <button onclick="updateSensor('${zoneId}', '${field}')">Modificar Sensor</button>
                    <hr size="2px" color="000000" width="auto">
                `;

                sensorsContainer.appendChild(sensorContainer);
            }
        }

        zoneElement.appendChild(sensorsContainer);

        // Botón para agregar nuevos sensores
        const addSensorButton = document.createElement('button');
        addSensorButton.textContent = 'Agregar Nuevo Sensor';
        addSensorButton.onclick = () => addNewSensor(zoneId);

        zoneElement.appendChild(addSensorButton);

        // Botón para borrar la zona
        const deleteZoneButton = document.createElement('button');
        deleteZoneButton.textContent = 'Borrar Zona';
        deleteZoneButton.onclick = () => deleteZone(zoneId);

        zoneElement.appendChild(deleteZoneButton);

        zonesContainer.appendChild(zoneElement);
    });
}

window.deleteZone = async function (zoneId) {
    const confirmDelete = confirm('¿Seguro que quieres borrar esta zona?');
    if (confirmDelete) {
        await deleteData(zoneId, 'zones');
        loadZones(); // Actualizar la pantalla después de borrar
    }
}


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