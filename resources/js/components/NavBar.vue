<template>
    <div class="flex flex-col ml-2">
        <router-link v-for="item in items" :key="item.title" v-if="item.show" :to="item.to" class="font-normal text-xl mb-2">
            {{item.title}}
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
                    {title: 'Home', to: '/', show: true},
                    {title: 'Login', to: '/login', show: !User.loggedIn()},
                    {title: 'Register', to: '/register', show: !User.loggedIn()},
                    {title: 'Edit Profile', to: '/edituser', show: User.loggedIn()},
                    {title: 'Create Question', to: '/createquestion', show: User.loggedIn()},   
                    {title: 'Manage Categories', to: '/categories', show: User.loggedIn()},   
                    {title: 'Logout', to: '/logout', show: User.loggedIn()},          
                ]
            }
        }
    }
</script>
