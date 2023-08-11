<template>
    <div class="my-10 block border border-neutral-300 p-3 rounded-3xl bg-zinc-100">
        <div class="py-4 text-right text-sm">
            {{ post.date }}
        </div>
        <div>
            <img v-if="post.image" :src="post.image" alt="post image">
        </div>
        <h3 class="text-2xl my-2">
            {{ post.title }}
        </h3>
        <div>
            <p>
                {{ post.content }}
            </p>
            <div class="flex mt-3 ml-5">
                <svg @click.prevent="like(post)" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                     :class="['w-6 h-6 stroke-red-600 cursor-pointer hover:fill-red-600', post.is_liked ? 'fill-red-600' : 'fill-none']">
                    <path
                        d="M9.653 16.915l-.005-.003-.019-.01a20.759 20.759 0 01-1.162-.682 22.045 22.045 0 01-2.582-1.9C4.045 12.733 2 10.352 2 7.5a4.5 4.5 0 018-2.828A4.5 4.5 0 0118 7.5c0 2.852-2.044 5.233-3.885 6.82a22.049 22.049 0 01-3.744 2.582l-.019.01-.005.003h-.002a.739.739 0 01-.69.001l-.002-.001z"/>
                </svg>
                <div class="ml-2">
                    {{ post.likes }}
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "Posts",
    props: [
        'post'
    ],

    methods: {
        like(post) {
            axios.get(`/api/posts/${post.id}/like`)
                .then( res => {
                    post.is_liked = res.data.is_liked;
                    post.likes = res.data.likes;
                })
        },
    }
}
</script>

<style scoped>

</style>
