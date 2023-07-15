import './bootstrap';
import { createApp } from 'vue';
import router from './router'
import axios from 'axios'


const app = createApp({});

import BaseComponent from './components/BaseComponent.vue';
app.component('base-component', BaseComponent);

app.use(router)

app.config.globalProperties.axios = axios

app.mount('#app');
