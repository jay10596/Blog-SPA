<template>
    <div class="w-full my-6 flex justify-center">
        <form @submit.prevent="editUser" class="px-8 pt-6 pb-8 mb-4 w-2/6 bg-white shadow-md rounded justify-center absolute">
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="username">Name</label>
                
                <input v-if="userForm.name" v-model="userForm.name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="username" type="text" placeholder="User Name">
                
                <span v-if="errors.name" class="text-red-700 pt-1 text-sm" role="alert">
                        {{errors.name[0]}}
                </span>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="password">Birthday</label>
                
                <input v-model="userForm.birthday" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="birthday" placeholder="mm/dd/yyyy">
            
                <span v-if="errors.birthday" class="text-red-700 pt-1 text-sm" role="alert">
                        {{errors.birthday[0]}}
                </span>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="password">Email</label>
                
                <input v-model="userForm.email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="email" placeholder="user@email.com">

                <span v-if="errors.email" class="text-red-700 pt-1 text-sm" role="alert">
                        {{errors.email[0]}}
                </span>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="password">Email</label>
                
                <input v-model="userForm.password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="password" placeholder="New password ****">
            
                <span v-if="errors.password" class="text-red-700 pt-1 text-sm" role="alert">
                        {{errors.password[0]}}
                </span>
            </div>

            <ImageUpload/>

            <div class="flex pt-4 items-center justify-between">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Save
                </button>
            </div>
        </form>
    </div>
</template>

<script>
    import ImageUpload from '../extras/ImageUpload'

    export default {
        name: 'EditUser',

        data() {
            return {
                userForm: {
                    name: '',
                    birthday: '',
                    email: '',
                    password: '',
                    avatar: null           
                },
                user: '',
                errors: {},
            }
        },

        components: {ImageUpload},

        created() {
            this.listen()
            this.me()
        },

        methods: {
            me() {
                axios.post('/api/auth/me')
                    .then(res => {
                        this.user = res.data
                        this.userForm = this.user
                    })
                    .catch(errors => console.log(errors))
            },

            listen() {
                EventBus.$on('uploadingImage', (uploadedImage) => {
                    this.userForm.avatar = uploadedImage
                })
            },

            editUser() {
                this.errors = {}
                axios.put(`/api/users/${this.user.id}`, this.userForm)
                    .then(res => window.location = '/')
                    .catch(errors => {
                        this.errors = errors.response.data.errors

                        if(errors.response.status === 500)
                        {
                            window.location = '/'
                        }
                    })
            },
        }
    }
</script>

<style>

</style>