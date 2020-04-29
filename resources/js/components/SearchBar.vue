<template>
    <div class="flex justify-end">
        <!-- <div v-if="focus" @click="focus=false" class="bg-black absolute opacity-25 right-0 left-0 top-0 bottom-0 z-10"></div> -->

        <SearchTab/>

        <ImageCircle :name="userName" :avatar="userImage"/>
    </div>
</template>

<script>
    import SearchTab from './extras/SearchTab'
    import ImageCircle from './extras/ImageCircle'

    export default {
        name: "SearchBar",

        components: {ImageCircle, SearchTab},

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
            }
        },
    }
</script>

<style scoped>

</style>