<template>
    <div class="flex w-full">
        <div class="flex-col w-4/6">
            <div v-if="categoryQuestions[0]" class="text-center flex justify-center">
                <CategoryBox :category="categoryQuestions[0].category"/>
            </div>
            
            <div v-for="question in categoryQuestions" :key="question.id">
                <QuestionCard :question="question"/>
            </div>
        </div>

        <div class="flex-col w-2/6">
            <MaxQuestionsBox/>
        </div>

    </div>
    
</template>

<script>
    import QuestionCard from '../extras/QuestionCard'
    import CategoryBox from '../extras/CategoryBox'
    import MaxQuestionsBox from '../extras/MaxQuestionsBox'

    export default {
        name: 'CategoryQuestions',

        components: {QuestionCard, CategoryBox, MaxQuestionsBox},

        data() {
            return {
                categoryQuestions: ''
            }
        },

        created() {
             axios.get(`/api/categories/${this.$route.params.slug}`)
                .then(res => this.categoryQuestions = res.data.data)
                .catch(errors => console.log(errors))
        }
    }
</script>

<style>

</style>