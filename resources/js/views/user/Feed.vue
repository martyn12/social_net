<template>
    <div class="block p-8 w-1/3 mx-auto">
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
            posts: [],
        }
    },

    components: {
        Posts
    },

    mounted() {
        this.getPosts()
    },

    methods: {
        getPosts() {
            axios.get(`/api/feed`)
                .then( res => {
                    this.posts = res.data.data
                })
        },

    },

}
</script>

<style scoped>

</style>
