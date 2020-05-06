<template>
    <div class="m-3 bg-white rounded overflow-hidden shadow-lg">
        <div class="px-6 py-3">
            <div class="flex items-center justify-between">
                <div class="flex">
                    <ImageCircle :name="question.user_name" :avatar="question.user_avatar"/>

                    <router-link v-if="question" :to="'/users/' + question.user_id" class="font-semibold text-md ml-2 text-blue-600">
                        {{question.user_name}}

                        <p class="text-gray-600 text-xs font-light">
                            {{question.created_at}}
                        </p>
                    </router-link>
                </div>

                <div>
                    <router-link v-if="question" :to="'/categories/' + question.category.slug" class="inline-block bg-gray-300 rounded-full px-3 py-1 text-sm font-semibold text-gray-800 mr-2">
                        #{{question.category.name}}
                    </router-link>
                </div>
            </div>
        </div>
        
        <div class="px-6 py-4">            
            <router-link v-if="question" :to="'/questions/' + question.slug" class="font-normal text-gray-900 text-lg">
                {{question.title}}
            </router-link>

            <p class="text-gray-800 text-sm mt-2">
                {{question.body}}
            </p>
        </div>

        <div class="px-6 py-4 flex items-center">
            <Favourite :slug="question.slug" :count="question.favourite_count" :favourited="question.favourited"/>

            <div v-if="question.replies" class="rounded-lg shadow-2xl border w-32 ml-6 border-gray-400 bg-transparent text-xs text-center text-blue-700 font-semibold py-2 px-4">
                Total Replies: {{question.replies.length}}
            </div>
        </div>

        <div v-if="message != null && errorQuestionSlug == question.slug" class="px-6 py-4 text-sm text-red-500">
            {{message}}
        </div>
    </div>
</template>

<script>
    import ImageCircle from './ImageCircle'
    import Favourite from './Favourite'

    export default {
        name: 'QuestionCard',

        components: {ImageCircle, Favourite},

        props: ['question'],

        data() {
            return {
                message: null,
                errorQuestionSlug: null
            }
        },

        created() {
            EventBus.$on('displayingError', (slug) => {
                this.errorQuestionSlug = slug
                this.message = "*Please Login to add this question to favourites!*"
            })
        }
    }
</script>

<style>

</style>