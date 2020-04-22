<template>
    <div>
        <div v-if="categoryQuestions[0]">
            {{categoryQuestions[0].category.name}}
        </div>
        
        <div v-for="question in categoryQuestions" :key="question.id">
            <Card :question="question"/>
        </div>
    </div>

</template>

<script>
    import Card from '../extras/Card'

    export default {
        name: 'CategoryQuestions',

        components: {Card},

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