<template>
    <div class="flex-col">
        <div class="text-center">
            <i class="fab fa-blogger font-normal text-11xl mt-10 mb-5 text-blue-800"></i>
        </div>

        <router-link v-for="item in items" :key="item.title" v-if="item.show" :to="item.to" class="font-normal text-xl mb-2">
            <div class="flex items-center m-5">
                <i :class="item.icon" class="h-12 w-12 text-blue-800 m-2 hover:text-blue-500"></i>
                
                <p class="text-gray-700 font-bold text-xs uppercase m-2 hover:text-blue-500">
                    {{item.title}}
                </p>
            </div>
        </router-link> 
    </div>
</template>

<script>
    export default {
        name: "NavBar",

        created() {
            EventBus.$on('logout', () => {
                User.logout()
            })
        },

        data(){
            return {
                items: [
                    {title: 'Home', icon: 'fas fa-home', to: '/', show: true},
                    {title: 'Login', icon: 'fas fa-sign-in-alt', to: '/login', show: !User.loggedIn()},
                    {title: 'Register', icon: 'fas fa-user-plus', to: '/register', show: !User.loggedIn()},
                    {title: 'Edit Profile', icon: 'fas fa-user-cog', to: '/edituser', show: User.loggedIn()},
                    {title: 'Create Question', icon: 'fas fa-plus-square', to: '/createquestion', show: User.loggedIn()}, 
                    {title: 'Favourites', icon: 'fas fa-heart', to: '/favourites', show: User.loggedIn()},   
                    {title: 'Manage Categories', icon: 'fas fa-tasks', to: '/categories', show: User.loggedIn()},   
                    {title: 'Logout', to: '/logout', icon: 'fas fa-sign-out-alt', show: User.loggedIn()},          
                ],
            }
        }
    }
</script>
