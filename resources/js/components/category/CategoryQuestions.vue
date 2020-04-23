<template>
    <div>
        <div v-if="categoryQuestions[0]">
            <CategoryBox :category="categoryQuestions[0].category"/>
        </div>
        
        <div v-for="question in categoryQuestions" :key="question.id">
            <QuestionCard :question="question"/>
        </div>
    </div>

</template>

<script>
    import QuestionCard from '../extras/QuestionCard'
    import CategoryBox from '../extras/CategoryBox'

    export default {
        name: 'CategoryQuestions',

        components: {QuestionCard, CategoryBox},

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