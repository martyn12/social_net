<template>
    <div class="my-10 block border border-neutral-100 p-3 rounded-3xl shadow">
        <div class="py-4 text-right text-sm">
            {{ post.date }}
        </div>
        <div>
            <img v-if="post.image" :src="post.image" alt="post image">
        </div>
        <h3 class="text-2xl my-2">
            {{ post.title }}
        </h3>
        <p>
            {{ post.content }}
        </p>
        <div v-if="post.reposted_post" class="p-4 border border-neutral-300 rounded-3xl mt-4">
            <div class="py-4 text-right text-sm">
                {{ post.reposted_post.date }}
            </div>
            <div>
                <img v-if="post.reposted_post.image" :src="post.reposted_post.image" alt="post image">
            </div>
            <h3 class="text-2xl my-2">
                {{ post.reposted_post.title }}
            </h3>
            <p>
                {{ post.reposted_post.content }}
            </p>
        </div>
        <div>
            <div class="flex mt-3 ml-5">
                <div class="flex mr-4">
                    <svg @click.prevent="like(post)" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                         fill="currentColor"
                         :class="['w-6 h-6 stroke-red-600 cursor-pointer hover:fill-red-600', post.is_liked ? 'fill-red-600' : 'fill-none']">
                        <path
                            d="M9.653 16.915l-.005-.003-.019-.01a20.759 20.759 0 01-1.162-.682 22.045 22.045 0 01-2.582-1.9C4.045 12.733 2 10.352 2 7.5a4.5 4.5 0 018-2.828A4.5 4.5 0 0118 7.5c0 2.852-2.044 5.233-3.885 6.82a22.049 22.049 0 01-3.744 2.582l-.019.01-.005.003h-.002a.739.739 0 01-.69.001l-.002-.001z"/>
                    </svg>
                    <p class="ml-2">
                        {{ post.likes_count }}
                    </p>
                </div>

                <div class="flex mr-4">
                    <svg @click.prevent="openRepostForm" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                         stroke-width="1.5"
                         stroke="currentColor"
                         :class="['w-6 h-6 stroke-sky-600 cursor-pointer hover:fill-sky-600', post.isReposted ? 'fill-sky-600' : 'fill-none']">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M7.217 10.907a2.25 2.25 0 100 2.186m0-2.186c.18.324.283.696.283 1.093s-.103.77-.283 1.093m0-2.186l9.566-5.314m-9.566 7.5l9.566 5.314m0 0a2.25 2.25 0 103.935 2.186 2.25 2.25 0 00-3.935-2.186zm0-12.814a2.25 2.25 0 103.933-2.185 2.25 2.25 0 00-3.933 2.185z"/>
                    </svg>

                    <p class="ml-2">
                        {{ post.reposts }}
                    </p>
                </div>

                <div class="flex mr-4">
                    <svg v-if="!isComment" @click.prevent="getComments(post)" xmlns="http://www.w3.org/2000/svg"
                         viewBox="0 0 24 24"
                         stroke-width="1.5" stroke="currentColor"
                         class="w-6 h-6 stroke-sky-600 cursor-pointer hover:fill-sky-600 fill-none">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z"/>
                    </svg>
                    <svg v-if="isComment" @click.prevent="this.isComment = false" xmlns="http://www.w3.org/2000/svg"
                         viewBox="0 0 24 24"
                         stroke-width="1.5" stroke="currentColor"
                         class="w-6 h-6 stroke-sky-600 cursor-pointer hover:fill-sky-600 fill-none">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z"/>
                    </svg>


                    <p class="ml-2">
                        {{ post.comments_count }}
                    </p>
                </div>

            </div>
        </div>
        <div v-if="isRepost" class="p-4">
            <div>
                <input type="text" placeholder="title" v-model="title"
                       class="border rounded-full border-stone-400 p-1 w-96">
            </div>
            <div class="text-sm mb-3 text-red-500">
                <p v-for="error in errors.title">
                    {{ error }}
                </p>
            </div>
            <div>
            <textarea type="text" placeholder="content" v-model="content"
                      class="mt-2 border rounded-3xl border-stone-400 p-1 w-96"></textarea>
            </div>
            <div class="text-sm mb-3 text-red-500">
                <p v-for="error in errors.content">
                    {{ error }}
                </p>
            </div>
            <div>
                <button @click.prevent="repost(post)"
                        class="mt-2 w-36 p-1 border border-blue-400 rounded-3xl bg-blue-400 text-white
                    hover:bg-white hover:text-blue-400 hover:border-blue-400">
                    Publish
                </button>
            </div>
        </div>
        <div class="mt-4">
            <div v-if="parentId" class="text-sky-600 flex">
                Answer to {{ commentToAnswer.user.name }}
                <div class="cursor-pointer text-sky-600 ml-3 underline" @click="this.parentId = null">
                    Cancel
                </div>
            </div>
            <div>
                <input type="text" placeholder="comment here" v-model="comment_body"
                       class="border rounded-full border-stone-400 p-1 w-96">
            </div>
            <div class="text-sm mb-3 text-red-500">
                <p v-for="error in errors.body">
                    {{ error }}
                </p>
            </div>
        </div>
        <div>
            <button @click.prevent="comment(post)"
                    class="mt-2 w-36 p-1 border border-blue-400 rounded-3xl bg-blue-400 text-white
                    hover:bg-white hover:text-blue-400 hover:border-blue-400">
                Comment
            </button>
        </div>
        <div v-if="isComment" class="p-4">
            <div v-if="this.comments.length > 0" class="mb-4">
                <div v-for="comment in this.comments">
                    <div class="mb-5 p-3 shadow shadow-gray-200 rounded-2xl">
                        <div class="w-96 flex justify-between">
                            <div class="text-lg mb-2">
                                <div class="flex">
                                    <p class="mr-5">
                                        {{ comment.user.name }}
                                    </p>
                                    <p @click="setParentId(comment)" class="cursor-pointer text-sky-600">
                                        answer
                                    </p>
                                </div>
                            </div>
                            <p class="text-sm text-right">
                                {{ comment.date }}
                            </p>
                        </div>
                        <div class="flex">
                            <p v-if="comment.parent" class="mr-1 text-sky-600">
                                {{ comment.parent.user.name }},
                            </p>
                            <p>
                                {{ comment.body }}
                            </p>
                        </div>
                    </div>

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

    data() {
        return {
            title: '',
            content: '',
            isRepost: false,
            isComment: false,
            isReposted: false,
            reposts: null,
            comment_body: '',
            errors: [],
            comments: [],
            parentId: null,
            commentToAnswer: null
        }
    },

    methods: {
        like(post) {
            axios.post(`/api/posts/${post.id}/like`)
                .then(res => {
                    post.is_liked = res.data.is_liked;
                    post.likes_count = res.data.likes;
                })
        },

        openRepostForm() {
            if (this.$route.name !== 'user.personal') {
                this.isRepost = !this.isRepost
                this.isComment = false
            }
        },

        repost(post) {
            axios.post(`/api/posts/${post.id}/repost`,
                {
                    title: this.title,
                    content: this.content
                }).then(res => {
                this.isReposted = res.data.isReposted
                this.reposts = res.data.reposts
                this.title = ''
                this.content = ''
                this.isRepost = false
            }).catch(e => {
                this.errors = e.response.data.errors;
            })
        },


        comment(post) {
            axios.post(`/api/posts/${post.id}/comment`,
                {
                    body: this.comment_body,
                    parent_id: this.parentId
                }).then(res => {
                this.comment_body = ''
                this.getComments(post)
                this.parentId = null
                post.comments_count++
            }).catch(e => {
                this.errors = e.response.data.errors
            })
        },

        getComments(post) {
            axios.get(`/api/posts/${post.id}/comment`)
                .then(res => {
                    this.isComment = true
                    this.comments = res.data.data
                })
        },

        setParentId(comment) {
            this.parentId = comment.id
            this.commentToAnswer = comment;
        }
    }
}
</script>

<style scoped>

</style>
