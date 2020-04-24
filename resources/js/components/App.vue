<template>
    <div class="flex h-screen bg-gray-100">
        <div class="w-56 bg-white border-r-2 border-gray-300">
            <NavBar/>
        </div>

        <div class="flex flex-col w-full h-screen">
            <div class="bg-white p-2 border-b-2 border-gray-300">
                <SearchBar/>
            </div>

            <div class="flex flex-col overflow-y-hidden">
                <router-view class="overflow-x-hidden"></router-view>
            </div>
        </div>
    </div>
</template>

<script>
    import NavBar from "./NavBar"
    import SearchBar from "./SearchBar"

    export default {
        name: "App",
        
        components: {NavBar, SearchBar}
    }
</script>

<style scoped>

</style>
