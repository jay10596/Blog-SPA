<template>
    <div>
        <div class="flex justify-center">
            <div class="w-4/6">
                <div v-for="question in questions" :key="question.id">
                    <QuestionCard :question="question"/>
                </div>

                <div class="flex justify-between m-3 my-5 rounded w-auto font-sans">
                    <div>
                        <a @click="getQuestions(pagination.first_page_url)" class="block text-blue-800 bg-white hover:text-blue-500 hover:border-blue-500 border border-gray-400 px-3 py-2 rounded" href="#">First</a>
                    </div>

                    <div>
                        <ul class="flex justify-center">
                            <li @click="getQuestions(pagination.prev_page_url)"><a :class="prevDisable" class="block border border-gray-300 px-3 py-2 rounded" href="#"><i class="fas fa-backward"></i></a></li>
                            <li><a class="cursor-not-allowed block text-blue-800 bg-white border border-gray-400 px-3 py-2 rounded" href="#">Page {{pagination.current_page}} of {{pagination.last_page}}</a></li>
                            <li @click="getQuestions(pagination.next_page_url)"><a :class="nextDisable" class="block border border-gray-300 px-3 py-2 rounded" href="#"><i class="fas fa-forward"></i></a></li>
                        </ul>
                    </div>

                    <div>
                        <a @click="getQuestions(pagination.last_page_url)" class="block text-blue-800 bg-white hover:text-blue-500 hover:border-blue-500 border border-gray-400 px-3 py-2 rounded" href="#">Last</a>
                    </div>
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
    </div>
    
</template>

<script>
    import QuestionCard from '../extras/QuestionCard'
    import CategoryBox from '../extras/CategoryBox'

    export default {
        name: 'ThisMonthQuestions',

        components: {QuestionCard, CategoryBox},

        data() {
            return {
                questions: '',
                categories: '',
                pagination: {}
            }
        },

        computed: {
            prevDisable() {
                return this.pagination.prev_page_url ? 'text-blue-800 bg-white hover:text-blue-500 hover:border-blue-500' : 'cursor-not-allowed text-gray-500 bg-gray-100'
            },

            nextDisable() {
                return this.pagination.next_page_url ? 'text-blue-800 bg-white hover:text-blue-500 hover:border-blue-500' : 'cursor-not-allowed text-gray-500 bg-gray-100'
            }
        },

        created() {
            this.getQuestions()
            this.getCategories()
        },

        methods: {
            getQuestions(page_url) {
                page_url = page_url || 'api/thismonthquestions'

                axios.post(page_url)
                    .then(res => {
                        this.questions = res.data.data
                        this.makePagination(res.data.meta, res.data.links)
                    })
                    .catch(errors => console.log(errors))
            },

            makePagination(meta, links) {
                this.pagination = {
                    current_page: meta.current_page,
                    last_page: meta.last_page,
                    
                    next_page_url: links.next,
                    prev_page_url: links.prev,
                    first_page_url: links.first,
                    last_page_url: links.last
                }
            },

            getCategories() {
                axios.get('api/categories')
                    .then(res => this.categories = res.data.data)
                    .catch(errors => console.log(errors))
            }
        }
    }
</script>

<style>

</style>