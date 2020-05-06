<template>
    <div>
        <div class="flex" @click="markRead">
            <ImageCircle :name="item.user_name" :avatar="item.user_avatar"/>

            <router-link :to="item.path" class="flex-col ml-2 w-64">
                <p class="text-sm font-normal"><span class="text-sm font-semibold text-blue-500">{{item.user_name}}</span> {{item.message}}</p>
            </router-link>

            <p class="w-32 mt-1 text-xs font-light text-gray-600 text-right">{{item.created_at}}</p>
        </div>
        
        <p class="ml-12 text-xs font-normal text-gray-700 mt-2">{{item.questionOrReply}}</p>
    </div>
</template>

<script>
    import ImageCircle from './ImageCircle'

    export default {
        name: 'NotificationCard',

        components: {ImageCircle},

        props: ['item'],

        methods: {
            markRead() {
                EventBus.$emit('markingRead', (this.item))
            },
        }
    }
</script>

<style>

</style>