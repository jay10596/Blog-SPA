<template>
    <div class="w-4/6 m-3 p-3 bg-white rounded shadow-xl">
        <div class="px-4 py-4">
            <div class="w-full flex items-center">
                <div class="w-5/6 flex items-center">
                    <ImageCircle :name="reply.user_name" :avatar="reply.user_avatar"/>

                    <router-link :to="'/users/' + reply.user_id" class="font-semibold text-md ml-2 text-blue-600">
                        {{reply.user_name}}

                        <p class="text-gray-600 text-xs font-light">
                            {{reply.created_at}}
                        </p>
                    </router-link>
                </div>
                
                <div v-if="own" class="relative w-1/6 flex mb-4justify-end">            
                    <button @click="changeEditMode" class="w-16 mx-2 px-2 py-1 border border-blue-600 text-blue-600 text-xs rounded focus:outline-none outline-none hover:bg-blue-600 hover:text-white"> <i class="fas fa-edit"></i> </button>
                    <button @click="deleteMode = true" class="w-20 mx-2 px-2 py-1 border border-red-600 text-red-600 text-xs rounded focus:outline-none hover:bg-red-600 hover:text-white"> <i class="fas fa-trash-alt"></i> </button>

                    <div v-if="deleteMode" class="absolute bg-blue-900 rounded-lg right-0 text-white w-64 z-10 mt-8 p-2">
                        <p>Are you sure you want to delete this reply?</p>

                        <div class="flex items-center justify-end mt-2">
                            <button @click="deleteReply" class="mx-2 px-4 py-2 bg-red-500 rounded-full text-sm focus:outline-none hover:bg-red-600">Delete</button>
                            <button @click="deleteMode = false" class="text-sm focus:outline-none hover:text-gray-400">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div v-if="editMode" class="flex px-6 mb-4">            
            <input v-model="replyForm.body" class="appearance-none bg-transparent border border-gray-400 w-full text-gray-700 mr-3 py-1 px-2 leading-tight focus:outline-none" type="text" placeholder="Category name">

            <button @click="editReply" class="mx-2 px-2 border border-green-500 text-green-500 text-white text-sm rounded-full focus:outline-none hover:bg-green-500 hover:text-white"><i class="fas fa-save"></i></button>
            <button @click="editMode = false" class="px-2 border border-gray-700 text-gray-700 text-sm rounded-full focus:outline-none hover:bg-gray-700 hover:text-white"><i class="fas fa-times"></i></button>
        </div>

        <div v-else class="px-6 mb-4">            
            <p class="ml-10 text-gray-800 text-sm">
                {{reply.body}}
            </p>
        </div>

        <div v-if="deleteMode" class="bg-black opacity-25 absolute z-0 left-0 top-0 right-0 bottom-0" @click="deleteMode = false"></div>
            
        <Like :reply="reply"/>

    </div>
</template>

<script>
    import ImageCircle from './ImageCircle'
    import Like from './Like'

    export default {
        name: 'ReplyCard',

        components: {ImageCircle, Like},

        props: ['reply', 'index'],

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
                deleteMode: false,
				editMode: false
            }
        },

        methods: {
            deleteReply() {
                axios.delete(`/api/questions/${this.$route.params.slug}/replies/${this.reply.id}`)
                    .then(res => {
                        this.deleteMode = false
                        EventBus.$emit('deletingReply', this.index)
                        EventBus.$emit('changingMaxRepliesCount')
                    })
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