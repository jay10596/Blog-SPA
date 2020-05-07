<template>
    <div class="flex flex-wrap justify-center overflow-auto h-96">
        <div v-for="user in userQuestions" :key="user.id">
            <router-link :to="'/users/' + user[0].user_id">
                <div v-if="user[0].user_avatar != null">
                    <img :src="user[0].user_avatar" class="flex justify-center object-cover items-center w-32 h-32 m-3 rounded shadow-xl border-2 hover:border-blue-600" alt="Profile Pic">
                </div>

                <div v-else class="flex justify-center text-center items-center w-32 h-32 m-3 bg-white text-gray-700 rounded shadow-xl border-2 hover:border-blue-600">
                    {{user[0].user_name}}
                </div>

                <p class="text-sm text-gray-800 text-center">
                    Total Replies: {{user.length}}
                </p>
            </router-link>
        </div>
    </div>
</template>

<script>
export default {
    name: 'MaxQuestionsBox',

    data() {
        return {
            userQuestions: '',
        }
    },

    created() {
        axios.post('/api/maximumquestions', {
            slug: this.$route.params.slug
        })
            .then(res => this.userQuestions = res.data)
            .catch(errors => console.log(errors))
    },
}
</script>

<style>

</style>