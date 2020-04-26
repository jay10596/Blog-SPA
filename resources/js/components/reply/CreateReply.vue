<template>
    <div class="my-10">
        <form class="flex items-center m-3 w-full max-w-sm" @submit.prevent="createReply">
            <ImageCircle :name="user_name"/>

            <div class="flex items-center border-b border-b-2 border-blue-500 py-2">
                <input v-model="replyForm.body" class="appearance-none bg-transparent border-none w-full text-gray-700 mr-3 py-1 px-2 leading-tight focus:outline-none" type="text" placeholder="Category name">
                
                <button type="submit" class="flex-shrink-0 bg-blue-500 hover:bg-blue-700 border-blue-500 hover:border-blue-700 text-sm border-4 text-white py-1 px-2 rounded"> Create </button>
            </div>
        </form>
    </div>
</template>

<script>
    import ImageCircle from '../extras/ImageCircle'

    export default {
        name: 'CreateReply',

        components: {ImageCircle},

        data() {
            return {
                replyForm: {
                    body: ''
                },
                errors: {},
                user_name: ''
            }
        },

        created() {
            if(User.loggedIn()) {
                this.user_name = User.name()
            }
        },

        methods: {
            createReply() {
                axios.post(`/api/questions/${this.$route.params.slug}/replies`, this.replyForm)
                    .then(res => {
                        this.replyForm.body = ''
                        EventBus.$emit('creatingReply', res.data.data)
                    })
                    .catch(error => this.errors = error.response.data.error)
            }
        }
    }
</script>

<style>

</style>