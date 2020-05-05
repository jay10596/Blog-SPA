<template>
    <div class="flex flex-col">
        <button @click="favouriteIt" :class="color" class="focus:outline-none">
            <i class="fas fa-heart"></i> {{count}}
        </button>
    </div>
</template>

<script>
    export default {
        name: 'Favourite',

        props: ['slug', 'count', 'favourited'],

        computed: {
            color() {
                return this.favourited ? 'text-red-500' : 'text-gray-700'
            }
        },

        methods: {
            favouriteIt() {
                if(User.loggedIn()) {
                    this.favourited ? this.removeFavourite() : this.addFavourite()
                    this.favourited = !this.favourited
                } else {
                    EventBus.$emit('displayingError', (this.slug))
                }
            },

            addFavourite() {
                axios.post(`/api/questions/${this.slug}/favourite`)
                    .then(res => this.count ++)
                    .catch(errors => console.log(errors))
            },

            removeFavourite() {
                axios.delete(`/api/questions/${this.slug}/favourite`)
                    .then(res => this.count --)
                    .catch(errors => console.log(errors))
            }
        }

    }
</script>

<style>

</style>