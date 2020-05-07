<template>
    <div class="flex w-full">
        
        <div class="w-4/6">
            <div v-for="question in questions" :key="question.id">
                <QuestionCard :question="question"/>
            </div>
        </div>
       
        <div class="flex justify-center pt-3">
            <ProfileCard :user="user"/>
        </div>
    </div>
</template>

<script>
    import QuestionCard from '../extras/QuestionCard'
    import ProfileCard from '../extras/ProfileCard'

    export default {
        name: 'UserQuestions',

        components: {QuestionCard, ProfileCard},

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