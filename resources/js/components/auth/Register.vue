<template>
    <div class="w-full h-full flex justify-center items-center bg-fixed">
        <div class="bg-white w-96 rounded-lg shadow-2xl p-6 mt-4">

            <h1 class="text-3xl pt-6 text-blue-700">Welcome Back</h1>
            <h2 class="text-base text-gray-700">Enter your details below!</h2>

            <form class="mt-8" @submit.prevent="register">

                <div class="relative mb-4">
                    <label for="name" class="uppercase text-blue-700 text-xs font-bold absolute p-2">Name</label>

                    <input v-model="registerForm.name" class="pt-8 w-full rounded bg-transparent shadow-2xl p-2 appearance-none text-gray-700 border focus:outline-none focus:shadow-outline" type="text" placeholder="Register your name">

                    <span v-if="errors.name" class="text-gray-100 pt-1 text-sm" role="alert">
                        {{errors.name[0]}}
                    </span>
                </div>

                <div class="relative mb-4">
                    <label for="birthday" class="uppercase text-blue-700 text-xs font-bold absolute p-2">Birthday</label>

                    <input v-model="registerForm.birthday" class="pt-8 w-full rounded bg-transparent shadow-2xl p-2 appearance-none text-gray-700 border focus:outline-none focus:shadow-outline" type="text" placeholder="mm/dd/yyyy">

                    <span v-if="errors.birthday" class="text-gray-100 pt-1 text-sm" role="alert">
                        {{errors.birthday[0]}}
                    </span>
                </div>

                <div class="relative mb-4">
                    <label for="email" class="uppercase text-blue-700 text-xs font-bold absolute p-2">E-mail</label>

                    <input v-model="registerForm.email" class="pt-8 w-full rounded bg-transparent shadow-2xl p-2 appearance-none text-gray-700 border focus:outline-none focus:shadow-outline" type="email" placeholder="Register your email">

                    <span v-if="errors.email" class="text-gray-100 pt-1 text-sm" role="alert">
                        {{errors.email[0]}}
                    </span>
                </div>

                <div class="relative mb-4">
                    <label for="password" class="uppercase text-blue-700 text-xs font-bold absolute p-2">Password</label>

                    <input v-model="registerForm.password" class="pt-8 w-full rounded bg-transparent shadow-2xl p-2 appearance-none text-gray-700 border focus:outline-none focus:shadow-outline" type="password" placeholder="Enter your password">

                    <span v-if="errors.password" class="text-gray-100 pt-1 text-sm" role="alert">
                        {{errors.password[0]}}
                    </span>
                </div>

                <div class="relative mb-6">
                    <label for="password_confirmation" class="uppercase text-blue-700 text-xs font-bold absolute p-2">Password</label>

                    <input v-model="registerForm.password_confirmation" class="pt-8 w-full rounded bg-transparent shadow-2xl p-2 appearance-none text-gray-700 border focus:outline-none focus:shadow-outline" type="password" placeholder="Confirm your password">
                </div>

                <ImageUpload/>

                <div class="flex justify-center">
                    <button type="submit" class="mt-4 uppercase rounded-lg shadow-2xl border border-blue-700 bg-transparent text-blue-700 hover:bg-gray-100 hover:text-gray-100 hover:bg-blue-700 font-semibold py-2 px-4">
                        Register
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    import ImageUpload from '../extras/ImageUpload'

    export default {
        name: "Register",

        components: {ImageUpload},

        data() {
            return {
                registerForm: {
                    name: null,
                    birthday: null,
                    email: null,
                    password: null,
                    password_confirmation: null,
                    avatar: null
                },
                errors: {}
            }
        },

        created() {
            this.listen()
        },

        methods: {
            register() {
                 axios.post('/api/auth/signup', this.registerForm)
                    .then(res => User.responseAfterLogin(res))
                    .catch(error => this.errors = error.response.data.errors)
            },

            listen() {
                EventBus.$on('uploadingImage', (uploadedImage) => {
                    this.registerForm.avatar = uploadedImage
                })
            }

        }
    }
</script>

<style>

</style>
