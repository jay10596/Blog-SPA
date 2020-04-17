import Vue from 'vue';
import VueRouter from 'vue-router';
import ExampleComponent from '../components/ExampleComponent'
import Login from '../components/auth/Login'
import Register from '../components/auth/Register'


Vue.use(VueRouter);

export default new VueRouter({
    routes: [
        { path: '/', component: ExampleComponent},
        { path: '/login', component: Login},
        { path: '/register', component: Register},
    ],

    mode: 'history',

    hash: false
});