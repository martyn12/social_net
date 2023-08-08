<template>
    <div class="block p-8 w-1/3 mx-auto">
        <div
            class="block bg-blue-400 p-2 border border-blue-400 rounded-3xl text-white w-36
            text-center hover:bg-white hover:text-blue-400 hover:border-blue-400">
            <router-link :to="{name: 'user.post.create'}">Create a post</router-link>
        </div>
        <div v-for="post in posts" class="my-10 block border border-neutral-300 p-3 rounded-3xl bg-zinc-100">
            <div class="my-6 text-right text-sm">
                {{ post.date }}
            </div>
            <div>
                <img v-if="post.image" :src="post.image" alt="post image">
            </div>
            <h3 class="text-2xl my-3">
                {{ post.title }}
            </h3>
            <p>
                {{ post.content }}
            </p>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "Personal",
    data() {
        return {
            token: null,
            posts: []
        }
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
                .then( res => {
                    this.posts = res.data.data
                })
        }
    },

}
</script>

<style scoped>

</style>
