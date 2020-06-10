
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('../bootstrap');

import Vue from 'vue'
import ElementUI from 'element-ui'
import locale from 'element-ui/lib/locale/lang/zh-TW'
import 'element-ui/lib/theme-chalk/index.css'
import Routes from './routes';
import App from './views/App';
import VueYoutube from 'vue-youtube'
import VueScrollTo from 'vue-scrollto'
import './plungins/leaflet'

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
window.Vue = require('vue');

Vue.use(ElementUI, { locale });
Vue.use(VueYoutube);
Vue.use(VueScrollTo)

Vue.component('news-card', require('./components/NewsCard.vue').default);




const app = new Vue({
    el: '#app',
    router: Routes,
    render: h => h(App)
});

export default app;