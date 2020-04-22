<template>
    <div class="w-full h-full flex justify-center items-center bg-fixed">
        <div class="bg-transparent opacity-100 w-4/6 rounded-lg shadow-2xl border border-red-900 p-6">

            <form class="mt-8" @submit.prevent="createQuestion">

                <div class="reletive">
                    <label for="title" class="uppercase text-red-500 text-xs font-bold absolute p-1">Title</label>

                    <div class="col-md-6">
                        <input v-model="questionForm.title" class="pt-8 w-full rounded bg-transparent shadow-2xl p-1 outline-none text-gray-100 border border-red-900 focus:border-blue-100" type="text" placeholder="Add the title">

                        <span v-if="errors.title" class="text-gray-100 pt-1 text-sm" role="alert">
                            {{errors.title[0]}}
                        </span>
                    </div>
                </div>

                <div class="pt-3">
                    <label for="body" class="uppercase text-red-500 text-xs font-bold absolute p-1">Write the description</label>

                    <div class="">
                        <textarea v-model="questionForm.body" class="pt-8 w-full rounded bg-transparent shadow-2xl p-1 outline-none text-gray-100 border border-red-900 focus:border-blue-100" type="text" placeholder="Write the description">
                        
                        </textarea>
                        <span v-if="errors.body" class="text-gray-100 pt-1 text-sm" role="alert">
                            {{errors.body[0]}}
                        </span>
                    </div>
                </div>

                 <div class="pt-3">
                    <label for="category_id" class="uppercase text-red-500 text-xs font-bold absolute p-1">Category</label>

                    <div class="">
                        <select v-model="questionForm.category_id" class="block appearance-none w-full bg-transparent border border-red-900 text-gray-100 pt-6 p-1 rounded leading-tight focus:outline-none focus:bg-transparent focus:border-red-500">
                            <option v-for="category in categories" :key="category.id" :value="category.id">{{category.name}}</option>
                        </select>
                        
                        <span v-if="errors.category_id" class="text-gray-100 pt-1 text-sm" role="alert">
                            {{errors.category_id[0]}}
                        </span>
                    </div>

                    
                </div>

                <div class="">
                    <button type="submit" class="mt-8 uppercase rounded-lg shadow-2xl border border-red-900 bg-transparent text-gray-100 hover:bg-gray-100 hover:text-red-900 font-semibold w-full h-8 px-2 text-left">
                        Post Question
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'CreateQuestion',

        props: ['question'],

        data() {
            return {
                questionForm: {
                    title: null,
                    body: null,
                    category_id: null
                },
                categories: {},
                errors: {}
            }
        },

        mounted() {
            this.questionForm = this.question
        },

        created() {
            if(!User.loggedIn()) {
                this.$router.push('/')
            }

            axios.get('/api/categories')
                .then(res => this.categories = res.data.data)
                .catch(errors => console.log(errors))
        },

        methods: {
            createQuestion() {
                axios.post('/api/questions', this.questionForm)
                    .then(res => this.$router.push('/'))
                    .catch(error => this.errors = error.response.data.errors)
            }
        }
    }
</script>

<style>

</style>