import Vue from 'vue';
import VueRouter from 'vue-router';
import Dashboard from '../components/Dashboard'

import Login from '../components/auth/Login'
import Register from '../components/auth/Register'
import Logout from '../components/auth/Logout'

import UserQuestions from '../components/user/UserQuestions'
import EditUser from '../components/user/EditUser'
import FavouriteQuestions from '../components/user/FavouriteQuestions'

import CreateQuestion from '../components/question/CreateQuestion'
import QuestionReplies from '../components/question/QuestionReplies'
import ThisMonthQuestions from '../components/question/ThisMonthQuestions'

import CategoryCRUD from '../components/category/CategoryCRUD'
import CategoryQuestions from '../components/category/CategoryQuestions'


Vue.use(VueRouter);

export default new VueRouter({
    routes: [
        { path: '/', component: Dashboard},
        { path: '/login', component: Login},
        { path: '/register', component: Register},
        { path: '/logout', component: Logout},

        { path: '/users/:id', component: UserQuestions},
        { path: '/edituser', component: EditUser},
        { path: '/favourites', component: FavouriteQuestions},

        { path: '/createquestion', component: CreateQuestion},
        { path: '/questions/:slug', component: QuestionReplies},
        { path: '/thismonthquestions', component: ThisMonthQuestions},


        { path: '/categories', component: CategoryCRUD},
        { path: '/categories/:slug', component: CategoryQuestions},
    ],

    mode: 'history',

    hash: false
});