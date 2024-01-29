// Import the functions you need from the SDKs you need
import { initializeApp } from "https://www.gstatic.com/firebasejs/9.6.2/firebase-app.js";
// TODO: Add SDKs for Firebase products that you want to use
// https://firebase.google.com/docs/web/setup#available-libraries
import {
  getFirestore,
  collection,
  getDocs,
  onSnapshot,
  addDoc,
  deleteDoc,
  doc,
  getDoc,
  updateDoc,
} from "https://www.gstatic.com/firebasejs/9.6.2/firebase-firestore.js";

// Your web app's Firebase configuration
const firebaseConfig = {
   //Aquí añadimos los datos de API que nos ha asignado FireBase
   apiKey: "AIzaSyBP1PH_8GcHcs6dIamcCcfxEXRrCQFWwFQ",
   authDomain: "tomas-prueba.firebaseapp.com",
   projectId: "tomas-prueba",
   storageBucket: "tomas-prueba.appspot.com",
   messagingSenderId: "413315528244",
   appId: "1:413315528244:web:b4d4e9c425f400081dbc61",
   measurementId: "G-NZXCSEHRXP"

};

//Conectamos con la base de datos
const app = initializeApp(firebaseConfig);
const db = getFirestore()

//CRUD

export const saveData = (ref,objeto) => addDoc(collection(db,ref),objeto)
export const getDataCollection = (ref) => getDocs(collection(db,ref))
export const getDataChanged_collection = ( ref, callBack) => onSnapshot(collection(db,ref),callBack)
export const getDataChanged_document = (ref, document, callBack) => onSnapshot(doc(db,ref, document),callBack)
export const deleteData = (id, ref) => deleteDoc(doc(db,ref,id))
export const getData = (id, ref) => getDoc(doc(db,ref,id))
export const updateData = (id, ref,objeto) => updateDoc(doc(db,ref,id),objeto)