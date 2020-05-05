<template>
    <div class="my-10">
        <form class="flex items-stretch m-3" @submit.prevent="createReply">
            <ImageCircle :name="user.name" :avatar="user.avatar"/>

            <div class="flex flex-col w-full">
                <p class="ml-2 font-semibold text-md text-blue-600">{{user.name}}</p>
                
                <textarea v-model="replyForm.body" type="text" class="w-4/6 mx-2 my-2 shadow-inner p-4 border border-gray-400" placeholder="Enter your reply here..." rows="3"></textarea>
                
                <button type="submit" class="w-24 mt-4 ml-1 uppercase rounded-lg shadow-2xl border border-gray-400 text-xs text-gray-900 bg-white hover:border-blue-700 hover:text-blue-700 font-semibold py-2 px-2 focus:outline-none"><i class="fas fa-reply"></i> Reply</button>
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
                user: ''
            }
        },

        created() {
            if(User.loggedIn()) {
                axios.post('/api/auth/me')
                    .then(res => this.user = res.data)
                    .catch(errors => console.log(errors))
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