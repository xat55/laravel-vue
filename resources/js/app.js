
require('./bootstrap');
window.Vue = require('vue').default;

import App from './components/App';
import Navbar from './components/parts/Navbar';
import Index from './components/pages/posts/Index';
import ValidationErrors from './components/parts/ValidationErrors';

Vue.component('navbar', Navbar);
Vue.component('posts', Index);
Vue.component('validation-errors', ValidationErrors);

const app = new Vue({
    el: '#app', 
    render: h => h(App),
});
