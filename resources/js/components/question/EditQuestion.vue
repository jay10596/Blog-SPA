<template>
    <div class="w-full my-16 flex justify-center">
        <form @submit.prevent="editQuestion" class="px-8 pt-6 pb-8 mb-4 w-3/6 bg-white shadow-2xl rounded justify-center absolute">
            <h1 class="text-3xl py-3 text-blue-800">Edit Question:</h1>

            <div class="flex pb-6">
                <ImageCircle :name="question.user_name" :avatar="question.user_avatar"/>

                <router-link v-if="question" :to="'/users/' + question.user_id" class="font-semibold text-md ml-2 text-blue-600">
                    {{question.user_name}}

                    <p class="text-gray-600 text-xs font-light">
                        {{question.created_at}}
                    </p>
                </router-link>
            </div>
            
            <div class="reletive">
                <label for="title" class="uppercase text-blue-800 text-xs font-bold absolute p-2">Title</label>

                <div class="col-md-6">
                    <input v-model="questionForm.title" class="pt-8 w-full rounded bg-transparent shadow-2xl p-2 appearance-none text-gray-700 border focus:outline-none focus:shadow-outline" type="text" placeholder="Add the title">

                    <span v-if="errors.title" class="text-red-700 pt-1 text-sm" role="alert">
                        {{errors.title[0]}}
                    </span>
                </div>
            </div>

            <div class="pt-3">
                <label for="body" class="absolute uppercase text-blue-800 text-xs font-bold p-2">Edit the message</label>

                <div class="">
                    <textarea v-model="questionForm.body" rows="3" class="pt-8 w-full rounded bg-transparent shadow-2xl p-2 appearance-none text-gray-700 border focus:outline-none focus:shadow-outline" type="text" placeholder="Write the description">
                    
                    </textarea>
                    <span v-if="errors.body" class="text-red-700 pt-1 text-sm" role="alert">
                        {{errors.body[0]}}
                    </span>
                </div>
            </div>

            <div class="pt-3">
                <label for="category_id" class="uppercase text-blue-800 text-xs font-bold absolute p-2">Category</label>

                <div class="">
                    <select v-model="questionForm.category_id" class="pt-8 w-full rounded bg-transparent shadow-2xl p-2 appearance-none text-gray-700 border focus:outline-none focus:shadow-outline">
                        <option v-for="category in categories" :key="category.id" :value="category.id">{{category.name}}</option>
                    </select>
                    
                    <span v-if="errors.category_id" class="text-red-700 pt-1 text-sm" role="alert">
                        {{errors.category_id[0]}}
                    </span>
                </div>
            </div>

            <div class="">
                <button type="submit" class="mt-8 uppercase rounded-lg shadow-2xl border text-sm bg-gray-100 text-gray-100 bg-blue-700 hover:border-blue-800 hover:bg-transparent hover:text-blue-800 font-semibold py-2 px-4 focus:outline-none">
                    Update
                </button>

                <button @click="editCancel" class="mt-8 text-right uppercase rounded-lg text-blue-800 border text-sm hover:border-blue-800 font-semibold py-2 px-4 focus:outline-none">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</template>

<script>
    import ImageCircle from '../extras/ImageCircle'

    export default {
        name: 'EditQuestion',

        components: {ImageCircle},

        props: ['question'],

        data() {
            return {
                questionForm: {
                    title: null,
                    body: null,
                    category_id: null
                },
                categories: {},
                errors: {},
            }
        },

        mounted() {
            this.questionForm = this.question
        },

        created() {
            axios.get('/api/categories')
                .then(res => this.categories = res.data.data)
                .catch(errors => console.log(errors))
        },

        methods: {
            editQuestion() {
                axios.put(`/api/questions/${this.$route.params.slug}`, this.questionForm)
                    .then(res => {
                        this.editCancel()
                        this.$router.push('/')
                    })
                    .catch(error => this.errors = error.response.data.errors)
            },

            editCancel() {
                EventBus.$emit('editingCancel')
            }
        }
    }
</script>

<style>

</style>