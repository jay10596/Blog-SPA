<template>
    <div class="flex justify-center">
        <div class="w-4/6">
            <div v-for="question in questions" :key="question.id">
                <QuestionCard :question="question"/>
            </div>
        </div>

        <div class="w-2/6">
            <div class="flex flex-wrap justify-center overflow-auto h-96">
                <div v-for="category in categories" :key="category.id">
                    <CategoryBox :category="category"/>
                </div>
            </div>
        </div>  
    </div>
</template>

<script>
    import QuestionCard from './extras/QuestionCard'
    import CategoryBox from './extras/CategoryBox'

    export default {
        name: 'Dashboard',

        components: {QuestionCard, CategoryBox},

        data() {
            return {
                questions: '',
                categories: ''
            }
        },

        created() {
            axios.get('api/questions')
                .then(res => this.questions = res.data.data)
                .catch(errors => console.log(errors))

            axios.get('api/categories')
                .then(res => this.categories = res.data.data)
                .catch(errors => console.log(errors))
        }
    }
</script>

<style>

</style>
