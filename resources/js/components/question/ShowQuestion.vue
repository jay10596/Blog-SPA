<template>
    <div class="h-screen">
        <Card :question="question"/>

        <h1>total replies {{this.replies.length}}</h1>
        <br>

        <div v-if="own">
            <button @click="editQuestion">edit</button>

            <button @click="deleteQuestion">delete</button>
        </div>

        <CreateReply/>

        <div v-for="reply in replies" :key="reply.id" v-if="reply">
            <ReplyCard :reply="reply"/>
        </div>
    </div>
</template>

<script>
    import Card from '../extras/Card'
    import ReplyCard from '../extras/ReplyCard'
    import CreateReply from '../reply/CreateReply'

    export default {
        name: 'ShowQuestion',

        components: {Card, ReplyCard, CreateReply},

        props: ['question', 'replies'],

        computed: {
            own() {
                return User.own(this.question.user_id)
            }
        },

        created() {
            this.listen()
        },

        methods: {
            deleteQuestion() {
                axios.delete(`/api/questions/${this.$route.params.slug}`)
                    .then(this.$router.push('/'))
                    .catch(errors => console.log(errors))
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