<template>
    <div class="flex" @click="markRead">
        <ImageCircle :name="item.user_name" :avatar="item.user_avatar"/>

        <router-link :to="item.path" class="flex-col ml-2 w-64">
            <p class="text-sm font-semibold text-blue-500 ">{{item.user_name}}</p>
            <p class="text-xs font-normal">{{item.question}}</p>
        </router-link>

        <p class="w-32 text-xs font-light text-gray-600 text-right">{{item.created_at}}</p>
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