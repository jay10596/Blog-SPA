<template>
    <div>
        <button>
            <i class="far fa-thumbs-up"></i>Like
        </button>
    </div>
</template>

<script>
    export default {
        name: 'Like',

        props: ['reply'],
			        
        data() {
            return {
                liked: this.reply.liked,
                count: this.reply.like_count
            }
        },

        computed: {
            color() {
                return this.liked ? 'green' : 'gray'
            }
        },

        methods: {
            likeIt() {
                if(User.loggedIn) {
                    this.liked ? this.removeLike() : this.addLike()
                    this.liked = !this.liked
                }
            },

            addLike() {
                axios.post(`/api/${this.reply.id}/like`)
                    .then(res => this.count ++)
            },

            removeLike() {
                axios.delete(`/api/${this.reply.id}/like`)
                    .then(res => this.count --)
            }
        }

    }
</script>

<style>

</style>