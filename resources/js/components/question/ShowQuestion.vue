<template>
    <div class="h-screen ml-4">
        <div class="mx-3 my-6">
            <a href="#" class="font-semibold text-blue-800 hover:text-blue-500" @click="$router.back()">
                <i class="fas fa-angle-double-left mr-1"></i> Back
            </a>
        </div>
        
        <QuestionCard :question="question"/>

        <div v-if="own" class="relative mx-3">
            <button @click="editQuestion" class="mt-8 uppercase rounded-lg shadow-2xl border border-gray-300 text-xs text-gray-900 bg-white hover:border-blue-700 hover:text-blue-700 font-semibold py-2 px-3 focus:outline-none"><i class="fas fa-edit"></i> Edit</button>
            <button @click="deleteMode = true" class="mt-8 uppercase rounded-lg shadow-2xl border border-gray-300 text-xs text-gray-900 bg-white hover:border-red-500 hover:text-red-500 font-semibold py-2 px-3 focus:outline-none"><i class="fas fa-trash"></i> Delete</button>
        
            <div v-if="deleteMode" class="ml-3 absolute bg-blue-900 rounded-lg text-white w-2/6 z-10 mt-2 p-3">
                <p>Are you sure you want to delete this contact?</p>

                <div class="flex items-center justify-end mt-3">
                    <button @click="deleteQuestion" class="ml-6 px-4 py-2 bg-red-500 rounded text-sm">Delete</button>
                    <button @click="deleteMode = false" class="text-sm">Cancel</button>
                </div>
            </div>
        </div>

        <CreateReply v-if="loggedIn"/>

        <div class="ml-24 border-l-4 border-blue-500">
            <div v-for="(reply, index) in replies" :key="reply.id" v-if="reply" class="">
                <ReplyCard :reply="reply" :index="index"/>
            </div>
        </div>

        <div v-if="deleteMode" class="bg-black opacity-25 absolute z-0 left-0 top-0 right-0 bottom-0" @click="deleteMode = false"></div>
    </div>
</template>

<script>
    import QuestionCard from '../extras/QuestionCard'
    import ReplyCard from '../extras/ReplyCard'
    import CreateReply from '../reply/CreateReply'

    export default {
        name: 'ShowQuestion',

        components: {QuestionCard, ReplyCard, CreateReply},

        props: ['question', 'replies'],

        computed: {
            own() {
                return User.own(this.question.user_id)
            },

            loggedIn() {
                return User.loggedIn()
            }
        },

        data() {
            return {
                deleteMode:false
            }
        },

        created() {
            this.listen()
        },

        methods: {
            deleteQuestion() {
                axios.delete(`/api/questions/${this.$route.params.slug}`)
                    .then(this.$router.push('/'))
                    .catch(errors => console.log(errors));
            },

            editQuestion() {
                EventBus.$emit('editingQuestion')
            },

            listen() {
                EventBus.$on('creatingReply', (reply) => {
                    this.replies.unshift(reply)
                })

                EventBus.$on('deletingReply', (index) => {
                    this.replies.splice(index, 1)
                })

                Echo.private('App.User.' + User.id())
                    .notification((notification) => {
                        if(notification.reply) {
                            this.question.replies.unshift(notification.reply)
                        }
                    })

                Echo.channel('removeReplyChannel')
                    .listen('RemoveReplyEvent', (e) => {
                        for(let index = 0; index< this.replies.length; index++) {
                            if(this.replies[index].id == e.id) {
                                this.replies.splice(index, 1)
                            }
                        }
                    })
            },
        },    
    }
</script>

<style>

</style>