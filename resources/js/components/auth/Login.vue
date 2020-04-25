<template>
    <div class="w-full my-32 flex justify-center">
        <form @submit.prevent="login" class="px-8 pt-6 pb-8 mb-4 w-2/6 bg-white shadow-2xl rounded justify-center absolute">
            
            <h1 class="text-3xl pt-6 text-blue-700">Welcome Back</h1>
            <h2 class="text-base text-gray-700">Enter your details below!</h2>

            <div class="my-8">
                <label for="email" class="uppercase text-blue-700 text-xs font-bold absolute p-2">E-mail</label>

                <input v-model="loginForm.email" class="pt-8 w-full rounded bg-transparent shadow-2xl p-2 appearance-none text-gray-700 border focus:outline-none focus:shadow-outline" type="text" placeholder="Enter your Email">

                <span v-if="errors.email" class="text-red-700 pt-1 text-sm" role="alert">
                    {{errors.email[0]}}
                </span>
            </div>

            <div class="mb-4">
                <label for="password" class="uppercase text-blue-700 text-xs font-bold absolute p-2">Password</label>

                <input v-model="loginForm.password" class="pt-8 w-full rounded bg-transparent shadow-2xl p-2 appearance-none text-gray-700 border focus:outline-none focus:shadow-outline" type="password" placeholder="Enter your password">

                <span v-if="errors.password" class="text-red-700 pt-1 text-sm" role="alert">
                    {{errors.password[0]}}
                </span>
            </div>

            <div class="mb-4">
                <button type="submit" class="mt-8 uppercase rounded-lg shadow-2xl border border-blue-700 bg-transparent text-blue-700 hover:bg-gray-100 hover:text-gray-100 hover:bg-blue-700 font-semibold py-2 px-4">
                    Login
                </button>
            </div>

            <div class="flex justify-between text-gray-800">
                <a class="btn btn-link" href="">
                    Forget Your Password?
                </a>
            </div>
        </form>
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
                    .catch(errors => this.errors = errors.response.data.errors)
            }

        }
    }
</script>

<style>

</style>
