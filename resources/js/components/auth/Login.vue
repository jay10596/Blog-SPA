<template>
    <div class="w-full h-full flex justify-center items-center bg-fixed" style="background-image: url(https://images.wallpapersden.com/image/download/eagle-mountain-sunset-minimalist_63668_2048x1152.jpg)">
        <div class="bg-transparent opacity-100 w-96 rounded-lg shadow-2xl border border-red-900 p-6">

            <h1 class="text-3xl pt-6 text-gray-100">Welcome Back</h1>
            <h2 class="text-base text-gray-200">Enter your details below!</h2>

            <form class="mt-8" @submit.prevent="login">

                <div class="reletive">
                    <label for="email" class="uppercase text-red-500 text-xs font-bold absolute p-1">E-mail</label>

                    <div class="col-md-6">
                        <input v-model="loginForm.email" class="pt-8 w-full rounded bg-transparent shadow-2xl p-1 outline-none text-gray-100 border border-red-900 focus:border-blue-100" type="text" placeholder="Enter your Email">

                        <span v-if="errors.email" class="text-gray-100 pt-1 text-sm" role="alert">
                            {{errors.email[0]}}
                        </span>
                    </div>
                </div>

                <div class="pt-3">
                    <label for="password" class="uppercase text-red-500 text-xs font-bold absolute p-1">Password</label>

                    <div class="">
                        <input v-model="loginForm.password" class="pt-8 w-full rounded bg-transparent shadow-2xl p-1 outline-none text-gray-100 border border-red-900 focus:border-blue-100" type="password" placeholder="Enter your password">

                        <span v-if="errors.password" class="text-gray-100 pt-1 text-sm" role="alert">
                            {{errors.password[0]}}
                        </span>
                    </div>
                </div>

                <div class="">
                    <button type="submit" class="mt-8 uppercase rounded-lg shadow-2xl border border-red-900 bg-transparent text-gray-100 hover:bg-gray-100 hover:text-red-900 font-semibold w-full h-8 px-2 text-left">
                        Login
                    </button>
                </div>

                <div class="flex justify-between mt-8 text-gray-100">
                    <a class="btn btn-link" href="">
                        Forget Your Password?
                    </a>

                    <a class="btn btn-link" href="">
                        Register
                    </a>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Login",

        data() {
            return {
                loginForm: {
                    email: null,
                    password: null
                },
                errors: {}
            }
        },

        methods: {
            login() {
                 axios.post('/api/auth/login', this.loginForm)
                    .then(res => User.responseAfterLogin(res))
                    .catch(error => this.errors = error.response.data.errors)
            }

        }
    }
</script>

<style>

</style>
