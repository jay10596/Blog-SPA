<template>
    <div>
        <div v-if="userImage != null">
            <img class="w-10 h-10 mx-auto object-cover rounded-full" :src="avatar" alt="Profile Pic">
        </div>
        
        <div v-else class="rounded-full text-white bg-blue-400 w-10 h-10 border border-gray-300 flex justify-center items-center">
            {{userName}}    
        </div>
    </div>
</template>

<script>
    export default {
        name: 'ImageCircle',

        props: [
            'name', 'avatar'
        ],

        computed: {
            userName() {
                if(this.name.length > 1) {
                    return this.name.match(/[A-Z]/g).slice(0, 2).join('')
                }
                
                return '?'
            },

            userImage() {
                return this.avatar
            }
        }
    }
</script>

<style>

</style>