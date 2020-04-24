<template>
    <div class="w-full my-6 flex justify-center">
        <form @submit.prevent="editUser" class="px-8 pt-6 pb-8 mb-4 w-2/6 bg-white shadow-md rounded justify-center absolute">
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="username">Name</label>
                
                <input v-model="userForm.name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="username" type="text" placeholder="User Name">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="password">Birthday</label>
                
                <input v-model="userForm.birthday" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="birthday" placeholder="mm/dd/yyyy">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="password">Email</label>
                
                <input v-model="userForm.email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="email" placeholder="user@email.com">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="password">Email</label>
                
                <input v-model="userForm.password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="password" placeholder="New password ****">
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
                    password: ''           
                },
                user: '',
                errors: {},
            }
        },

        components: {ImageUpload},

        created() {
            axios.post('/api/auth/me')
                .then(res => {
                    this.user = res.data
                    this.userForm = this.user
                })
                .catch(errors => console.log(errors))
        },

        methods: {
            editUser() {
                axios.put(`/api/users/${this.user.id}`, this.userForm)
                    .then(this.$router.push('/'))
                    .catch(errors => this.errors = errors.response)
            },
        }
    }
</script>

<style>

</style>