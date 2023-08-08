<template>
    <div class="block p-8 w-1/3 mx-auto">
        <h2 v-if="posts.length === 0" class="text-center text-2xl">
            {{userName}} еще ничего не запостил
        </h2>
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
            posts: [],
            userId: this.$route.params.id,
            userName: ''
        }
    },

    components: {
        Posts
    },

    mounted() {
        this.getPosts()
        this.getToken()
        this.getUser()
    },

    methods: {
        getToken() {
            this.token = localStorage.getItem('x_xsrf_token')
        },

        getPosts() {
            axios.get(`/api/users/${this.userId}/posts`)
                .then( res => {
                    this.posts = res.data.data
                })
        },

        getUser() {
            axios.get(`/api/users/${this.userId}`)
                .then( res => {
                    this.userName = res.data
                })
        }
    },

}
</script>

<style scoped>

</style>
