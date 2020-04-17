<template>
    <div class="flex justify-end">
        <router-link v-for="item in items" :key="item.title" v-if="item.show" :to="item.to">{{item.title}}</router-link>
    </div>
</template>

<script>
    export default {
        name: "SearchBar",

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
                    {title: 'Logout', to: '/logout', show: User.loggedIn()},             
                ]
            }
        }
    }
</script>

<style scoped>

</style>