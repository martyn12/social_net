<template>
    <div class="block p-8 w-1/3 mx-auto">
        <Stat :stat="stats"></Stat>
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
import Stat from "@/views/components/Stat.vue";

export default {
    name: "Personal",
    data() {
        return {
            posts: [],
            stats: []
        }
    },

    components: {
        Posts,
        Stat
    },

    mounted() {
        this.getPosts()
        this.getStats()
    },

    methods: {
        getPosts() {
            axios.get('/api/post')
                .then(res => {
                    this.posts = res.data.data
                })
        },

        getStats() {
            axios.post('/api/users/stats', {
                user_id: null
            }).then( res => {
                this.stats = res.data.data
            })
        }
    },

}
</script>

<style scoped>

</style>
