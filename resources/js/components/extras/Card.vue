<template>
    <div class="m-3 bg-white rounded overflow-hidden shadow-lg">
        <div class="px-6 py-4">
            <div class="flex items-center">
                <ImageCircle :name="question.user_name"/>

                <router-link v-if="question" :to="'/users/' + question.user_id" class="font-semibold text-md ml-2 text-blue-600">
                    {{question.user_name}}

                    <p class="text-gray-600 text-xs font-light">
                        {{question.created_at}}
                    </p>
                </router-link>
            </div>
        </div>
        
        <div class="px-6 py-4">            
            <router-link v-if="question" :to="'/questions/' + question.slug" class="font-normal text-lg mb-2">
                {{question.title}}
            </router-link>

            <p class="text-gray-800 text-sm">
                {{question.body}}
            </p>
        </div>

        <div class="px-6 py-4">
            <router-link v-if="question" :to="'/categories/' + question.category.slug" class="inline-block bg-gray-300 rounded-full px-3 py-1 text-sm font-semibold text-gray-800 mr-2">
                #{{question.category.name}}
            </router-link>
        </div>
    </div>
</template>

<script>
    import ImageCircle from './ImageCircle'

    export default {
        name: 'Card',

        components: {ImageCircle},

        props: ['question']
    }
</script>

<style>

</style>