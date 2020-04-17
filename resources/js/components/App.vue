<template>
    <div class="flex">
        <div class="bg-blue-800 w-56">
            <NavBar/>
        </div>

        <div class="w-full">
            <div class="bg-gray-400">
                <SearchBar/>
            </div>

            <div class="flex flex-col bg-gray-200 h-screen">
                <router-view></router-view>
                
                <div class="bg-green-300">Hey</div>
               
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
