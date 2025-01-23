import axios from 'axios';
import type { AxiosResponse } from 'axios';


// Definimos la URL base del servidor JSON
const BASE_URL = 'http://localhost:3000/tareas';

// Definimos la interfaz para el objeto de Tarea
export interface Tarea {
    id:string;
    titulo: string;
    fecha:string;
    hora: string;
    tipo: string;
    descripcion: string;
}

// Función para obtener todas las tareas
export const obtenerTareas = async (): Promise<Tarea[]> => {
    try {
        const response: AxiosResponse<Tarea[]> = await axios.get(BASE_URL);
        return response.data;
    } catch (error) {
        console.error('Error al obtener la tarea:', error);
        return [];
    }
}

// Función para crear una nueva tarea
export const crearTarea = async (id:string, titulo:string,fecha:string,hora:string,tipo:string,descripcion:string): Promise<Tarea | null> => {
    try {
        const nuevaTarea: Tarea = {
            id: id,
            titulo: titulo,
            fecha:fecha,
            hora: hora,
            tipo: tipo,
            descripcion: descripcion
           };
        const response: AxiosResponse<Tarea> = await axios.post(BASE_URL, nuevaTarea);
        return response.data;
    } catch (error) {
        console.error('Error de creacion de tarea:', error);
        return null;
    }
}

// Función para actualizar una tarea existente
export const actualizarTarea = async (id:string, titulo:string, fecha:string, hora:string, tipo:string, descripcion:string): Promise<Tarea | null> => {
    try {
        const tareaActualizada: Tarea = {
            id: id,
            titulo: titulo,
            fecha:fecha,
            hora: hora,
            tipo: tipo,
            descripcion: descripcion
        }
        const response: AxiosResponse<Tarea> = await axios.put(`${BASE_URL}/${id}`, tareaActualizada);
        return response.data;
    } catch (error) {
        console.error('Error al actualizar la tarea:', error);
        return null;
    }
}

// Función para eliminar una tarea
export const eliminarTarea = async (id: string): Promise<boolean> => {
    try {
        await axios.delete(`${BASE_URL}/${id}`);
        return true;
    } catch (error) {
        console.error('Error de eliminacion de tarea:', error);
        return false;
    }
}
