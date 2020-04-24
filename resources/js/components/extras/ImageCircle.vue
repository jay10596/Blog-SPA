<template>
    <div>
        <div v-if="uploadedImage != null && user.name == name ">
            <img class="w-10 h-10 mx-auto object-cover rounded-full" :src="uploadedImage" alt="Profile Pic">
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
            'name'
        ],

        data() {
            return {
                user: null,
                uploadedImage: null
            }
        },

        created() {
            axios.post('/api/auth/me')
                .then(res => {
                    this.user = res.data
                    this.uploadedImage = res.data.avatar
                })
                .catch(errors => console.log(errors))
        },

        computed: {
            userName() {
                if(this.name.length > 1) {
                    return this.name.match(/[A-Z]/g).slice(0, 2).join('')
                }
                
                return '?'
            },

            userImage() {
                return this.uploadedImage
            }
        }
    }
</script>

<style>

</style>