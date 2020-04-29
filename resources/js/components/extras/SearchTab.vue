<template>
    <div>
        <div v-if="focus" @click="focus = false" class="bg-black absolute opacity-25 right-0 left-0 top-0 bottom-0 z-10"></div>

        <div class="relative z-10">
            <div class="absolute"><i class="fa fa-search pt-2 pl-2 text-3xl fill-current text-gray-700"></i></div>
            
            <input type="text" id="searchTerm" v-model="searchTerm" @input="searchUsers" @focus="focus = true" placeholder="Search the user" class="rounded-full w-64 border border-gray-400 pl-10 p-2 mr-3 focus:outline-none text-sm text-black focus:shadow focus:border-blue-600">
            
            <div v-if="focus" class="absolute bg-white rounded-lg p-4 w-96 right-0 mr-6 mt-2 shadow z-20">
                <div v-if="searchResult.length == 0">No Result found for '{{searchTerm}}'</div>

                <div v-for="result in searchResult" :key='result.id' @click="focus=false">
                    <router-link :to="'/users/' + result.id" class="flex items-center p-2 border-b-2 border-gray-100 hover:bg-gray-100 hover:border-blue-500">
                        <ImageCircle :name="result.name" :avatar="result.avatar" class="mr-3"/>
                        
                        {{result.name}}
                    </router-link>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import _ from 'lodash';
    import ImageCircle from './ImageCircle'

    export default {
        name: 'SearchTab',

        components: {ImageCircle},

        data() {
            return {
                searchTerm: null,
                searchResult: '',
                focus: false
            }
        },

        methods: {
            searchUsers: _.debounce(function (e) {
                if(this.searchTerm.length < 2) {
                    return
                }

                axios.post('/api/search', {searchTerm: this.searchTerm})
                    .then(res => {
                        this.searchResult = res.data.data;
                        this.focus = true;
                        console.log(this.searchResult.length)
                    })
                    .catch(errors => {
                        console.log(errors)
                    })
            }, 500)
        }
    }
</script>

<style>

</style>