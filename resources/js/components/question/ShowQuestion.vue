<template>
    <div class="h-screen">
        <a href="#" class="text-blue-400" @click="$router.back()">Back</a>

        <QuestionCard :question="question"/>

        <h1>total replies {{this.replies.length}}</h1>

        <div v-if="own" class="relative">
            <button @click="editQuestion" class="mx-3 px-4 py-2 border border-blue-400 text-blue-400 text-sm rounded">edit</button>
            <button @click="deleteMode = true" class="px-4 py-2 border border-red-500 text-red-500 text-sm rounded">delete</button>
        
            <div v-if="deleteMode" class="ml-3 absolute bg-blue-900 rounded-lg text-white w-2/6 z-10 mt-2 p-3">
                <p>Are you sure you want to delete this contact?</p>

                <div class="flex items-center justify-end mt-3">
                    <button @click="deleteQuestion" class="ml-6 px-4 py-2 bg-red-500 rounded text-sm">Delete</button>
                    <button @click="deleteMode = false" class="text-sm">Cancel</button>
                </div>
            </div>
        </div>

        <CreateReply v-if="deleteMode == false"/>

        <div v-for="reply in replies" :key="reply.id" v-if="reply">
            <ReplyCard :reply="reply"/>
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
                    .catch(errors => {
                        alert('Inrernal Error! Enable to delete the contact.')

                        if(errors.res.status === 404)
                        {
                            this.$router.push('/');
                        }
                    });
            },

            editQuestion() {
                EventBus.$emit('editingQuestion')
            },

            listen() {
                EventBus.$on('creatingReply', (reply) => {
                    this.replies.unshift(reply)
                })

                EventBus.$on('deletingReply', (reply) => {
                    this.replies.splice(reply, 1)
                })
            }
        },    
    }
</script>

<style>

</style>