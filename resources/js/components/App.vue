<template>
    <div class="flex bg-gray-100" >
        <div class="w-56 border-r-2 border-blue-900">
            <NavBar/>
        </div>

        <div class="w-full">
            <div class="p-3 border-b-2 border-blue-900">
                <SearchBar/>
            </div>

            <div class="flex flex-col">
                <router-view></router-view>
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
