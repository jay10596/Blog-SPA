<template>
    <div>
        <router-link :to="'/categories/' + category.slug">
            <div class="flex justify-center items-center w-32 h-32 m-3 bg-white text-gray-700 rounded shadow-xl border-2 hover:border-blue-600">
                {{category.name}}
            </div>
        </router-link>
    </div>
</template>

<script>
    export default {
        name: 'CategoryBox',

        props: ['category'],
    }
</script>

<style>

</style>