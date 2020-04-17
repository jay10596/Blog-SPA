<template>
    <div class="w-full h-full flex justify-center items-center bg-fixed" style="background-image: url(https://images.wallpapersden.com/image/download/eagle-mountain-sunset-minimalist_63668_2048x1152.jpg)">
        <div class="bg-transparent opacity-100 w-96 rounded-lg shadow-2xl border border-red-900 p-6">

            <h1 class="text-3xl pt-6 text-gray-100">Welcome Back</h1>
            <h2 class="text-base text-blue-200">Enter your details below!</h2>

            <form class="mt-8" @submit.prevent="register">

                <div class="reletive">
                    <label for="name" class="uppercase text-red-500 text-xs font-bold absolute p-1">Name</label>

                    <div class="col-md-6">
                        <input v-model="registerForm.name" class="pt-8 w-full rounded bg-transparent shadow-2xl p-1 outline-none text-gray-100 border border-red-900 focus:border-blue-100" type="text" placeholder="Register your name">

                        <span v-if="errors.name" class="text-gray-100 pt-1 text-sm" role="alert">
                            {{errors.name[0]}}
                        </span>
                    </div>
                </div>

                <div class="pt-3">
                    <label for="birthday" class="uppercase text-red-500 text-xs font-bold absolute p-1">Birthday</label>

                    <div class="">
                        <input v-model="registerForm.birthday" class="pt-8 w-full rounded bg-transparent shadow-2xl p-1 outline-none text-gray-100 border border-red-900 focus:border-blue-100" type="text" placeholder="mm/dd/yyyy">

                        <span v-if="errors.birthday" class="text-gray-100 pt-1 text-sm" role="alert">
                            {{errors.birthday[0]}}
                        </span>
                    </div>
                </div>

                <div class="pt-3">
                    <label for="email" class="uppercase text-red-500 text-xs font-bold absolute p-1">E-mail</label>

                    <div class="">
                        <input v-model="registerForm.email" class="pt-8 w-full rounded bg-transparent shadow-2xl p-1 outline-none text-gray-100 border border-red-900 focus:border-blue-100" type="email" placeholder="Register your email">

                        <span v-if="errors.email" class="text-gray-100 pt-1 text-sm" role="alert">
                            {{errors.email[0]}}
                        </span>
                    </div>
                </div>

                <div class="pt-3">
                    <label for="password" class="uppercase text-red-500 text-xs font-bold absolute p-1">Password</label>

                    <div class="">
                        <input v-model="registerForm.password" class="pt-8 w-full rounded bg-transparent shadow-2xl p-1 outline-none text-gray-100 border border-red-900 focus:border-blue-100" type="password" placeholder="Enter your password">

                        <span v-if="errors.password" class="text-gray-100 pt-1 text-sm" role="alert">
                            {{errors.password[0]}}
                        </span>
                    </div>
                </div>

                <div class="pt-3">
                    <label for="password_confirmation" class="uppercase text-red-500 text-xs font-bold absolute p-1">Password</label>

                    <div class="">
                        <input v-model="registerForm.password_confirmation" class="pt-8 w-full rounded bg-transparent shadow-2xl p-1 outline-none text-gray-100 border border-red-900 focus:border-blue-100" type="password" placeholder="Confirm your password">
                    </div>
                </div>

                <div class="">
                    <button type="submit" class="mt-8 uppercase rounded-lg shadow-2xl border border-red-900 bg-transparent text-gray-100 hover:bg-gray-100 hover:text-red-900 font-semibold w-full h-8 px-2 text-left">
                        Register
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Register",

        data() {
            return {
                registerForm: {
                    name: null,
                    birthday: null,
                    email: null,
                    password: null,
                    password_confirmation: null
                },
                errors: {}
            }
        },

        methods: {
            register() {
                 axios.post('/api/auth/signup', this.registerForm)
                    .then(res => User.responseAfterLogin(res))
                    .catch(error => this.errors = error.response.data.errors)
            }

        }
    }
</script>

<style>

</style>
