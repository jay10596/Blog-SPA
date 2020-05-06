<template>
    <div class="flex flex-wrap justify-center overflow-auto h-96">
        <div v-for="user in userReplies" :key="user.id">
            <div v-if="user[0].user_avatar != null">
                <img :src="user[0].user_avatar" class="flex justify-center object-cover items-center w-32 h-32 m-3 rounded shadow-xl border-2 hover:border-blue-600" alt="Profile Pic">
            </div>

            <div v-else class="flex justify-center items-center w-32 h-32 m-3 bg-white text-gray-700 rounded shadow-xl border-2 hover:border-blue-600">
                {{user[0].user_name}}
            </div>

            <p class="text-sm text-gray-800 text-center">
                Total Replies: {{user.length}}
            </p>
        </div>
    </div>
</template>

<script>
export default {
    name: 'MaxRepliesBox',

    data() {
        return {
            userReplies: '',
        }
    },

    created() {
        axios.post('/api/maximumreplies', {
            slug: this.$route.params.slug
        })
            .then(res => this.userReplies = res.data)
            .catch(errors => console.log(errors))

        this.listen()
    },

    methods: {
        listen() {
             EventBus.$on('changingMaxRepliesCount', () => {
                axios.post('/api/maximumreplies', {
                    slug: this.$route.params.slug
                })
                    .then(res => this.userReplies = res.data)
            })
        }
    }

}
</script>

<style>

</style>