<template>
    <div class="flex">
        <div class="w-4/6">
            <div v-if="editingMode">
                <EditQuestion :question="question"/>
            </div>

            <div v-else>
                <ShowQuestion :question="question" :replies="replies"/>
            </div>
        </div>
        
        <div class="w-2/6">
            <MaxRepliesBox/>
        </div>
    </div>
</template>

<script>
    import ShowQuestion from './ShowQuestion'
    import EditQuestion from './EditQuestion'
    import MaxRepliesBox from '../extras/MaxRepliesBox'

    export default {
        name: 'QuestionReplies',

        components: {ShowQuestion, EditQuestion, MaxRepliesBox},

        data() {
            return {
                question: '',
                replies: '',
                editingMode: false
            }
        },

        created() {
            this.listen()

            axios.get(`/api/questions/${this.$route.params.slug}`)
                .then(res => {
                    this.question = res.data.data
                    this.replies = res.data.data.replies
                })
                .catch(errors => console.log(errors))
        },
        
        methods: {
            listen() {
                EventBus.$on('editingQuestion', () => {
                    this.editingMode = true
                }),

                EventBus.$on('editingCancel', () => {
                    this.editingMode = false
                })
            }
        }
    }
</script>

<style>

</style>