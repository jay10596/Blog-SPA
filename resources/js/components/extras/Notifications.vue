<template>
    <div class="relative">
        <button @click="isOpen = !isOpen" class="flex block focus:outline-none items-center">
            <div :class="color">
                <i class="fas fa-bell text-2xl mr-3"></i>
            </div>

            <p class="mr-5">{{unreadCount}}</p>
        </button>
        
        <div v-if="isOpen" @click="isOpen = false" class="fixed bg-black opacity-25 right-0 left-0 top-0 bottom-0"></div>

        <div v-if="isOpen" class="absolute right-0 mt-4 w-96 shadow-xl bg-white">
            <div v-for="item in unread" :key="item.id" class="py-3 px-3 border-b border-gray-300 bg-blue-100 hover:bg-white border-b hover:border-blue-500">
                <NotificationCard :item="item"/>
            </div>

            <div v-for="item in read" :key="item.id" class="py-3 px-3 border-b border-gray-300 hover:bg-blue-100 border-b hover:border-blue-500">
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
            getUnread() {
                axios.post('/api/notifications')
                    .then(res => {
                        this.read = res.data.read
                        this.unread = res.data.unread
                        this.unreadCount = res.data.unread.length
                    })
                    .catch(error => Exception.handle(error))
            },

            listen() {
                EventBus.$on('markingRead', (notification) => {
                    this.isOpen = false

                    if(this.read.includes(notification)) {
                        //
                    } else {
                        axios.post('/api/markasread', {id: notification.id})
                            .then(res => {
                                this.unread.splice(notification, 1)
                                this.read.push(notification)
                                this.unreadCount --
                            })
                    } 
                }),

                Echo.private('App.User.' + User.id())
                    .notification((notification) => {
                        this.unread.unshift(notification)
                        this.unreadCount ++
                    });
            },
        }
    }
</script>

<style>

</style>