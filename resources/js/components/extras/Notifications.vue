<template>
    <div class="relative">
        <button @click="isOpen = !isOpen" class="flex block focus:outline-none items-center">
            <div :class="color">
                <i class="fas fa-bell text-2xl mr-3"></i>
            </div>

            <p class="mr-5">{{unreadCount}}</p>
        </button>
        
        <div v-if="isOpen && unreadCount > 0" @click="isOpen = false" class="fixed bg-black opacity-25 right-0 left-0 top-0 bottom-0"></div>

        <div v-if="isOpen" class="absolute right-0 mt-4 py-2 px-2 w-96 shadow-xl bg-white rounded-lg">
            <div v-for="item in unread" :key="item.id">
                <NotificationCard :item="item"/>
            </div>
        </div>
    </div>
</template>

<script>
    import NotificationCard from './NotificationCard'

    export default {
        name: "Notifications",

        components: {NotificationCard},

        data() {
            return {
                isOpen: false,
                read: {},
                unread: {},
                unreadCount: null
            }
        },

        computed: {
            color() {
                return this.unreadCount > 0 ? 'text-blue-500' : 'text-gray-600';
            }
        },

        created() {
            this.listen()

            if(User.loggedIn()) {
                this.getUnread()
            }
        },

        methods: {
            listen() {
                EventBus.$on('markingRead', (notification) => {
                    this.isOpen = false

                    axios.post('/api/markasread', {id: notification.id})
                        .then(res => {
                            this.unread.splice(notification, 1)
                            this.read.push(notification)
                            this.unreadCount --
                        })
                })
            },

            getUnread() {
                axios.post('/api/notifications')
                    .then(res => {
                        this.read = res.data.read
                        this.unread = res.data.unread
                        this.unreadCount = res.data.unread.length
                    })
            }
        }
    }
</script>

<style>

</style>