
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

//amcharts3
import 'amcharts3'
import 'amcharts3/amcharts/serial'
import "amcharts3/amcharts/plugins/export/export.css"
import "amcharts3/amcharts/plugins/export/export.js"


import "amcharts3/amcharts/plugins/export/libs/blob.js/blob.js"
import "amcharts3/amcharts/plugins/export/libs/jszip/jszip.js"
import "amcharts3/amcharts/plugins/export/libs/jszip/jszip.min.js"
import "amcharts3/amcharts/plugins/export/libs/FileSaver.js/FileSaver.min.js"
import "amcharts3/amcharts/plugins/export/libs/FileSaver.js/FileSaver.js"
import "amcharts3/amcharts/plugins/export/libs/pdfmake/pdfmake.js"
import "amcharts3/amcharts/plugins/export/libs/fabric.js/fabric.js"
// import "amcharts3/amcharts/plugins/export/libs/xlsx/xlsx.js"

import "amcharts3/amcharts/plugins/export/libs/pdfmake/vfs_fonts.js"




// Vue.use(AmCharts);
// Vue.use(AmSerial);




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