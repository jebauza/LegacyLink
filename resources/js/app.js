require('./bootstrap');

window.Vue = require('vue').default;

Vue.mixin(require('./trans'))

/* Vuesax - Biblioteca para interfaz de usuario */
import Vuesax from 'vuesax';
import 'vuesax/dist/vuesax.css';
Vue.use(Vuesax, {
    colors: {
        primary: '#0bb7af',
        success: '#187de4',
        danger: '#ee2d41',
        warning: '#ee9d01',
        dark: '#131628'
    }
});

Vue.component('pagination', require('laravel-vue-pagination'));



Vue.component('office', require('./components/modules/offices/OfficeComponent').default);
Vue.component('employee', require('./components/modules/employees/EmployeeComponent').default);
Vue.component('deceasedProfile', require('./components/modules/deceasedProfiles/DeceasedProfileComponent').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
