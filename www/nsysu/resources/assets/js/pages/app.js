
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

import { LMap, LTileLayer, LMarker, LPopup,LIcon } from 'vue2-leaflet';

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

// 載入 css
import "leaflet/dist/leaflet.css";

// 啟用載入的各組件  vue2-leaflet
Vue.component("l-map", LMap);
Vue.component("l-tile-layer", LTileLayer);
Vue.component("l-marker", LMarker);
Vue.component("l-popup", LPopup);
Vue.component("l-icon", LIcon);


// 設定預設 icon
import { Icon } from "leaflet";
delete Icon.Default.prototype._getIconUrl;
Icon.Default.mergeOptions({
  iconRetinaUrl: require("leaflet/dist/images/marker-icon-2x.png"),
  iconUrl: require("leaflet/dist/images/marker-icon.png"),
  shadowUrl: require("leaflet/dist/images/marker-shadow.png")
});

Vue.config.productionTip = false;


const app = new Vue({
    el: '#app',
    router: Routes,
    render: h => h(App)
});

export default app;