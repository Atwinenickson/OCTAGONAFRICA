import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import './index.css'

// add use router and bind it to createApp so that users can route throught the application
createApp(App).use(router).mount('#app')