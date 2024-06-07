/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
import { createApp } from 'vue';
import router from './router';
import Navbar from './components/Navbar.vue';
// Import the functions you need from the SDKs you need
import { initializeApp } from "firebase/app";
import { getAnalytics } from "firebase/analytics";
// TODO: Add SDKs for Firebase products that you want to use
// https://firebase.google.com/docs/web/setup#available-libraries

/**
 * Next, we will create a fresh Vue application instance. You may then begin
 * registering components with the application instance so they are ready
 * to use in your application's views. An example is included for you.
 */
// Your web app's Firebase configuration
// For Firebase JS SDK v7.20.0 and later, measurementId is optional
const firebaseConfig = {
    apiKey: "AIzaSyCRETlkGnhUXiUuSnl6Yp-GIJ5hLpwwd-k",
    authDomain: "stadsjutters.firebaseapp.com",
    projectId: "stadsjutters",
    storageBucket: "stadsjutters.appspot.com",
    messagingSenderId: "172966720644",
    appId: "1:172966720644:web:4027f22898b043cf127ed1",
    measurementId: "G-BY7V4PPX24"
};

const app = createApp({});

const navbarApp = createApp(Navbar);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

Object.entries(import.meta.glob('./**/*.vue', { eager: true })).forEach(([path, definition]) => {
    app.component(path.split('/').pop().replace(/\.\w+$/, ''), definition.default);
});

/**
 * Finally, we will attach the application instance to a HTML element with
 * an "id" attribute of "app". This element is included with the "auth"
 * scaffolding. Otherwise, you will need to add an element yourself.
 */
// Initialize Firebase
const firebaseApp = initializeApp(firebaseConfig);
const analytics = getAnalytics(firebaseApp);

if (document.querySelector('header')) {
    navbarApp.use(router).mount('nav');
}
app.use(router).mount('main');





