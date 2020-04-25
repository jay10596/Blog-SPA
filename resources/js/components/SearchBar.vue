<template>
    <div class="flex justify-end">
        <input type="text" placeholder="Search the contacts" class="rounded-full w-64 border border-gray-400 pl-10 p-2 mr-3 focus:outline-none text-sm text-black focus:shadow focus:bg-gray-100 focus:border-blue-600">

        <ImageCircle :name="userName" :avatar="userImage"/>
    </div>
</template>

<script>
    import ImageCircle from './extras/ImageCircle'

    export default {
        name: "SearchBar",

        components: {ImageCircle},

        data() {
            return {
                userImage: null
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
       
        created() {
            if(User.loggedIn()) {
                axios.post('/api/auth/me')
                    .then(res => this.userImage = res.data.avatar)
            } 
        }
    }
</script>

<style scoped>

</style>