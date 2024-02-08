import {
    getData,
    updateData,
} from "../firebase/firebase.js";

document.addEventListener('DOMContentLoaded', async () => {
    const queryParams = new URLSearchParams(window.location.search);
    const type = queryParams.get('type');
    const zoneId = queryParams.get('zoneId');
    const name = queryParams.get(`${type}Name`);

    const modifyContainer = document.getElementById('modifyContainer');

    const data = await getData(zoneId, 'zones');

    if (type === 'sensor') {
        // Render UI for modifying sensor
        // You can create input fields, buttons, etc., and update the data accordingly
        // Example:
        modifyContainer.innerHTML = `
            <h2>Modify Sensor: ${name}</h2>
            <label>New Value:</label>
            <input type="number" id="newValue">
            <button onclick="modifySensor('${zoneId}', '${name}')">Update Sensor</button>
        `;
    } else if (type === 'executor') {
        // Render UI for modifying executor
        // You can create input fields, buttons, etc., and update the data accordingly
        // Example:
        modifyContainer.innerHTML = `
            <h2>Modify Executor: ${name}</h2>
            <label>Activate:</label>
            <input type="checkbox" id="activateExecutor">
            <button onclick="modifyExecutor('${zoneId}', '${name}')">Update Executor</button>
        `;
    }
});

window.modifySensor = async function (zoneId, sensorName) {
    const newValue = document.getElementById('newValue').value;

    if (newValue !== null) {
        const updatedData = {
            [sensorName]: parseInt(newValue) || 0,
        };

        await updateData(zoneId, 'zones', updatedData);
        window.opener.postMessage({ action: 'updateZone' }, '*');

    }
}

window.modifyExecutor = async function (zoneId, executorName) {
    const activateExecutor = document.getElementById('activateExecutor').checked;

    const updatedData = {
        [`executors.${executorName}`]: activateExecutor,
    };

    await updateData(zoneId, 'zones', updatedData);
    window.opener.postMessage({ action: 'updateZone' }, '*');

}
