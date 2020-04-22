<template>
    <div>
        {{user.name}}

        <div v-for="question in questions" :key="question.id">
            <Card :question="question"/>
        </div>
    </div>

</template>

<script>
    import Card from '../extras/Card'

    export default {
        name: 'UserQuestions',

        components: {Card},

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