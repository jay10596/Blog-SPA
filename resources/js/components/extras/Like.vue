<template>
    <div>
        <button @click="likeIt" :class="color" class="focus:outline-none">
            <i class="fas fa-thumbs-up ml-5"></i> {{count}}
        </button>

        <div v-if="message != null" class="mt-3 ml-5 text-sm text-red-500">
            {{message}}
        </div>
    </div>
</template>

<script>
    export default {
        name: 'Like',

        props: ['reply'],

        data() {
            return {
                id: this.reply.id,
                count: this.reply.like_count,
                liked: this.reply.liked,
                message: null
            }
        },

        computed: {
            color() {
                return this.liked ? 'text-green-500' : 'text-gray-700'
            }
        },

        methods: {
            likeIt() {
                if(User.loggedIn()) {
                    this.liked ? this.removeLike() : this.addLike()
                    this.liked = !this.liked
                } else {
                    this.message = "*Please Login to give a like!*"
                }
            },

            addLike() {
                axios.post(`/api/replies/${this.id}/like`)
                    .then(res => this.count++)
                    .catch(errors => console.log(errors))
            },

            removeLike() {
                axios.delete(`/api/replies/${this.id}/like`)
                    .then(res => this.count--)
                    .catch(errors => console.log(errors))
            }
        }

    }
</script>

<style>

</style>