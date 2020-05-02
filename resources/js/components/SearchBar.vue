<template>
    <div class="flex justify-end items-center">
        <div v-if="userLoggedIn"><Notifications/></div>

        <SearchTab/>

        <ImageCircle :name="userName" :avatar="userImage"/>
    </div>
</template>

<script>
    import SearchTab from './extras/SearchTab'
    import ImageCircle from './extras/ImageCircle'
    import Notifications from './extras/Notifications'

    export default {
        name: "SearchBar",

        components: {ImageCircle, SearchTab, Notifications},

        data() {
            return {
                userImage: null,
            }
        },

        created() {
            if(User.loggedIn()) {
                axios.post('/api/auth/me')
                    .then(res => this.userImage = res.data.avatar)
            } 
        },

        computed: {
            userName() {
                if(User.loggedIn()) {
                    return User.name()
                }

                return '?'
            },

            userLoggedIn() {
                return User.loggedIn()
            }
        },
    }
</script>

<style scoped>

</style>