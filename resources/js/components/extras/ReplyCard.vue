<template>
    <div class="w-3/6 m-3 bg-transparent rounded overflow-hidden shadow-xl">
        <div class="px-4 py-4">
            <div class="flex items-center">
                <ImageCircle :name="reply.user_name"/>

                <router-link :to="'/users/' + reply.user_id" class="font-semibold text-md ml-2 text-blue-600">
                    {{reply.user_name}}

                    <p class="text-gray-600 text-xs font-light">
                        {{reply.created_at}}
                    </p>
                </router-link>
            </div>
        </div>
        
        <div v-if="editMode" class="px-6 mb-4">            
            <input v-model="replyForm.body" class="appearance-none bg-transparent border-none w-full text-gray-700 mr-3 py-1 px-2 leading-tight focus:outline-none" type="text" placeholder="Category name">

            <button @click="editReply">Save</button>
            <button @click="editMode = false">cancel</button>
        </div>

        <div v-else class="px-6 mb-4">            
            <p class="ml-10 text-gray-800 text-sm">
                {{reply.body}}
            </p>
        </div>

        <div v-if="own" class="px-6 mb-4">            
            <button @click="changeEditMode">edit</button>
            <button @click="deleteReply">delete</button>
        </div>
    </div>
</template>

<script>
    import ImageCircle from './ImageCircle'

    export default {
        name: 'ReplyCard',

        components: {ImageCircle},

        props: ['reply'],

        computed: {
            own() {
                return User.own(this.reply.user_id)
            }
        },

        data() {
            return {
                replyForm: {
                    body: ''
                },
				editMode: false
            }
        },

        methods: {
            deleteReply() {
                axios.delete(`/api/questions/${this.$route.params.slug}/replies/${this.reply.id}`)
                    .then(res => EventBus.$emit('deletingReply', res.data.data))
                    .catch(error => this.errors = error.response.data.error)
            },

            changeEditMode() {
                this.editMode = true
                this.replyForm.body = this.reply.body
            },

            editReply() {
                axios.put(`/api/questions/${this.$route.params.slug}/replies/${this.reply.id}`, this.replyForm)
                    .then(res => {
                        this.reply.body = res.data.data.body
                        this.editMode = false
                    })
                    .catch(error => this.errors = error.response.data.error)
            }
        }
    }
</script>

<style>

</style>