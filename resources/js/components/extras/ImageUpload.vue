<template>
    <div>
        <label class="block text-gray-700 text-sm font-bold mb-2" for="password">Profile Picture</label>

        <input type="file" name='image' @change="getImage" class="py-2">

        <div v-if="uploadedImage != null" class="text-center">
            <img class="w-32 h-32 mx-auto mb-2 object-cover rounded-full" :src="uploadedImage" alt="Profile Pic">
    
            <i class="fas fa-upload mr-1"></i>
            <button @click.prevent="uploadImage">Upload</button>

            
            <i class="fas fa-trash-alt ml-5 mr-1"></i>
            <button @click.prevent="removeImage">Delete</button>
        </div>

        <div v-if="message" class="text-center mt-2 text-blue-700">
            {{message}}
        </div>
    </div>
</template>

<script>
    export default {
        name: 'ImageUpload',

        data() {
            return {
                uploadedImage: null,
                message: null
            }
        },

        created() {
            axios.post('/api/auth/me')
                .then(res => this.uploadedImage = res.data.avatar)
                .catch(errors => console.log(errors))
        },

        methods: {
            getImage(e) {
                let image = e.target.files[0]
                let reader = new FileReader()

                reader.readAsDataURL(image)
                reader.onload = e => {
                    this.uploadedImage = e.target.result
                }
            },

            uploadImage() {
                axios.post('/api/image', {'image': this.uploadedImage})
                    .then(res => {
                        this.uploadedImage = res.data.avatar
                        this.message = 'Profile picture is uploaded successfully!'
                    })
                    .catch(errors => console.log(errors))  
            },

            removeImage() {
                axios.delete('/api/image')
                    .then(res => {
                        this.uploadedImage = res.data.avatar
                        this.message = 'Profile picture is deleted successfully!'
                    })
                    .catch(errors => console.log(errors))
            }
        }
    }
</script>

<style>

</style>