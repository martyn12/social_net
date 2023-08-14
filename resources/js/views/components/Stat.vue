<template>
    <div class="flex justify-between mb-20">
        <div>
            Likes
            <div class="text-center text-sky-600">
                {{stat.likes_count}}
            </div>
        </div>
        <div>
            Subscribers
            <div class="text-center text-sky-600">
                {{stat.subscribers_count}}
            </div>
        </div>
        <div>
            Follows
            <div class="text-center text-sky-600">
                {{stat.follows_count}}
            </div>
        </div>
        <div>
            Posts
            <div class="text-center text-sky-600">
                {{stat.posts_count}}
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "Stat",
    props: [
        'stat'
    ],
}
</script>

<style scoped>

</style>
