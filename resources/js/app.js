require('./bootstrap');

window.Vue = require('vue').default;

Vue.mixin(require('./trans'))

/* Vuesax - Biblioteca para interfaz de usuario */
import Vuesax from 'vuesax';
import 'vuesax/dist/vuesax.css';
Vue.use(Vuesax, {
    colors: {
        primary: '#98C5EA',
        success: '#187de4',
        danger: '#ee2d41',
        warning: '#ee9d01',
        dark: '#131628'
    }
});

/* Element - Biblioteca para interfaz de usuario */
import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';
import locale from 'element-ui/lib/locale/lang/es';
Vue.use(ElementUI, { locale });

/* moment */
import moment from 'moment'
import 'moment/locale/es';
Vue.prototype.moment = moment
Vue.use(require('vue-moment'));

Vue.component('pagination', require('laravel-vue-pagination'));

Vue.component('office', require('./components/modules/offices/OfficeComponent').default);
Vue.component('employee', require('./components/modules/employees/EmployeeComponent').default);
Vue.component('deceasedProfile', require('./components/modules/deceasedProfiles/DeceasedProfileComponent').default);
Vue.component('user', require('./components/modules/users/UserComponent').default);
Vue.component('streaming', require('./components/modules/streaming/StreamingComponent').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});