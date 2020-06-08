
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('../bootstrap');
require('./custom');

import Vue from 'vue'
import ElementUI from 'element-ui'
import locale from 'element-ui/lib/locale/lang/zh-TW'
import 'element-ui/lib/theme-chalk/index.css'
import Multiselect from 'vue-multiselect'
import Twzipcode from 'vue2-twzipcode'
import { VueCropper } from 'vue-cropper'
import VCalendar  from 'v-calendar'
import 'v-calendar/lib/v-calendar.min.css';

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
window.Vue = require('vue');

Vue.use(ElementUI, { locale });
Vue.use(VCalendar);

Vue.component('multiselect', Multiselect);
Vue.component('modal', require('./components/Modal.vue').default);
Vue.component('intl-tel-input', require('./components/intl-tel-input/src/IntlTelInput.vue').default);
Vue.component('input-password', require('./components/InputPassword.vue').default);
Vue.component('number-input', require('./components/NumberInput.vue').default);
Vue.component('next-btm', require('./components/NextBtm.vue').default);
Vue.component('table-list', require('./components/TableList.vue').default);
Vue.component('vue-cropper', VueCropper);
Vue.component('cropper', require('./components/Cropper.vue').default);
Vue.component('img-cropper-upload', require('./components/ImgCropperUpload.vue').default);
Vue.component('twzipcode', Twzipcode);

/*const app = new Vue({
    el: '#app'
});*/
