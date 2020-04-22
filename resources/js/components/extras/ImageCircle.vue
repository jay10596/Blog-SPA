<template>
    <div v-if="name" class="rounded-full text-white bg-blue-400 w-10 h-10 border border-gray-300 flex justify-center items-center">
        {{userCircle}}    
    </div>
</template>

<script>
    export default {
        name: 'ImageCircle',

        props: [
            'name'
        ],

        computed: {
            userCircle() {
                if(this.name.length > 1) {
                    return this.name.match(/[A-Z]/g).slice(0, 2).join('')
                }
                
                return '?'
            }
        }
    }
</script>

<style>

</style>