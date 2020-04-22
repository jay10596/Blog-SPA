<template>
    <div class="flex justify-center">
        <div class="w-4/6">
            <div v-for="question in questions" :key="question.id">
                <Card :question="question"/>
            </div>
        </div>
        
        <div class="mx-auto">
            <div class="flex flex-col">
                <router-link :to="'/categories/' + category.slug" v-for="category in categories" :key="category.id">
                    {{category.name}}
                </router-link>
            </div> 
        </div>  
    </div>
</template>

<script>
    import Card from './extras/Card'

    export default {
        name: 'Dashboard',

        components: {Card},

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
