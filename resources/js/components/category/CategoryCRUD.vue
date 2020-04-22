<template>
    <div class="m-5">
        <form class="w-full max-w-sm" @submit.prevent="submitCategory">
            <div class="flex items-center border-b border-b-2 border-blue-500 py-2">
                <input v-model="categoryForm.name" class="appearance-none bg-transparent border-none w-full text-gray-700 mr-3 py-1 px-2 leading-tight focus:outline-none" type="text" placeholder="Category name">
                
                <div v-if="!editMode">
                    <button type="submit" class="flex-shrink-0 bg-blue-500 hover:bg-blue-700 border-blue-500 hover:border-blue-700 text-sm border-4 text-white py-1 px-2 rounded"> Create </button>
                </div>

                <div v-else>
                    <button  type="submit" class="flex-shrink-0 bg-white hover:bg-blue-700 border-blue-500 hover:border-blue-700 text-sm border-4 text-blue-500 py-1 px-2 rounded"> Update </button>
                
                    <button @click="cancelEdit" class="flex-shrink-0 border-transparent border-4 text-blue-500 hover:text-blue-800 text-sm py-1 px-2 rounded"> Cancel </button>    
                </div>
            </div>
        </form>

        <div v-for="(category, index) in categories" :key="category.id" class="flex my-3 mx-10">
            <div class="w-4/6">{{category.name}}</div>    

            <div class="flex w-2/6 justify-end">
                <button @click="changeEditMode(index)" class="mx-3">edit</button>

                <button @click="deleteCategory(index)" class="">delete</button>
            </div>

        </div>
    </div>
</template>

<script>
    export default {
        name: 'CategoryCRUD',

        data() {
            return {
                categoryForm: {
                    name: null
                },
                categories: '',
                errors: {},
                editMode: false,
                category: null
            }
        },

        created() {
            axios.get('/api/categories')
                .then(res => this.categories = res.data.data)
                .catch(errors =>errors.response.data)
        },

        methods: {
            submitCategory() {
                this.editMode == true ? this.updateCategory() : this.createCategory()
            },

            changeEditMode(index) {
                this.categoryForm.name = this.categories[index].name
                
                this.category = this.categories[index]

                this.categories.splice(index,1)

                this.editMode = true
            },

            createCategory() {
                axios.post('/api/categories', this.categoryForm)
                    .then(res => {
                        this.categories.unshift(res.data.data)
                        this.categoryForm.name = null
                    })
                    .catch(error => this.errors = error.response.data.error)
            },

            updateCategory() {
                axios.put(`/api/categories/${this.category.slug}`,  this.categoryForm)
                    .then(res => {
                        this.categories.unshift(res.data.data)
                        this.categoryForm.name = null
                        this.editMode = false
                    })
				    .catch(error => console.log(error))
            },

            deleteCategory(index) {
                axios.delete(`/api/categories/${this.categories[index].slug}`)
                    .then(res => this.categories.splice(index, 1))
				    .catch(error => console.log(error))
            },

            cancelEdit() {
                this.editMode = false
                this.categories.unshift(this.category)
                this.categoryForm.name = null
            }
        }
    }
</script>

<style>

</style>