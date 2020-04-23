<template>
    <div>
        <div class="flex m-8 bg-transparent rounded shadow-xl">
            <div class="w-4/6">{{category.name}}</div>    

            <div class="flex w-2/6 justify-end">
                <button @click="changeEditMode(index)" class="mx-3">edit</button>

                <button @click="deleteMode = true" class="">delete</button>
            </div>
        </div>

        <div class="flex">
            <div class="w-4/6"></div>    
            
            <div v-if="deleteMode" class="flex items-center w-3/6 bg-blue-900 rounded-lg text-white w-64 right-0 z-10 mt-2 p-3">
                <p>Are you sure you want to delete this contact?</p>
                
                <button @click="deleteCategory(index)" class="ml-4 px-4 py-2 bg-red-500 rounded text-sm">Delete</button>
                <button @click="deleteMode = false" class="text-sm">Cancel</button>          
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'CategoryCard',

        props: ['category', 'index'],

        data() {
            return {
                deleteMode: false
            }
        },

        methods: {
            changeEditMode(index) {
                EventBus.$emit('changingEditMode', index)
            },

            deleteCategory(index) {
                EventBus.$emit('deletingCategory', index)
            }
        }
    }
</script>

<style>

</style>