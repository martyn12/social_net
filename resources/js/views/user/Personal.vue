<template>
    <div class="block p-8 w-1/3 mx-auto">
        <div
            class="ml-48 bg-blue-400 p-2 border border-blue-400 rounded-3xl text-white w-36
            text-center hover:bg-white hover:text-blue-400 hover:border-blue-400">
            <router-link :to="{name: 'user.post.create'}">Create a post</router-link>
        </div>
        <Posts v-for="post in posts" :post="post"></Posts>
    </div>
</template>

<script>
import axios from "axios";
import Posts from "@/views/components/Posts.vue";

export default {
    name: "Personal",
    data() {
        return {
            token: null,
            posts: []
        }
    },

    components: {
        Posts
    },

    mounted() {
        this.getPosts()
        this.getToken()
    },

    methods: {
        getToken() {
            this.token = localStorage.getItem('x_xsrf_token')
        },

        getPosts() {
            axios.get('/api/post')
                .then(res => {
                    this.posts = res.data.data
                })
        }
    },

}
</script>

<style scoped>

</style>
