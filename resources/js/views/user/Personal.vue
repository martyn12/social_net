<template>
<div class="flex justify-between p-8 w-96 mx-auto">
    <div class="block bg-blue-400 p-2 border border-blue-400 rounded-3xl text-white w-36 text-center hover:bg-white hover:text-blue-400 hover:border-blue-400">
        <router-link :to="{name: 'user.post.create'}">Create a post</router-link>
    </div>
</div>
</template>

<script>
import axios from "axios";

export default {
    name: "Personal",
    data() {
        return {
            token: null
        }
    },

    mounted() {
        this.getToken()
    },

    methods: {
        getToken() {
            this.token = localStorage.getItem('x_xsrf_token')
        }
    }
}
</script>

<style scoped>

</style>
