<template>
    <div>
        {{user.name}}

        <div v-for="question in questions" :key="question.id">
            <QuestionCard :question="question"/>
        </div>
    </div>

</template>

<script>
    import QuestionCard from '../extras/QuestionCard'

    export default {
        name: 'UserQuestions',

        components: {QuestionCard},

        data() {
            return {
                user: '',
                questions: ''
            }
        },

        created() {
             axios.get(`/api/users/${this.$route.params.id}`)
                .then(res => {
                    this.user = res.data.data
                    this.questions = res.data.data.questions
                })
                .catch(errors => console.log(errors))
        }
    }
</script>

<style>

</style>