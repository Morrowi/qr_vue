import { createApp } from 'vue'
import App from './App.vue'
import FloatingVue from 'floating-vue'
import "bootstrap/dist/css/bootstrap.min.css";
import "floating-vue/dist/style.css"
import './assets/css/main.css'
import './assets/css/media.css'



createApp(App).use(FloatingVue).mount('#app')