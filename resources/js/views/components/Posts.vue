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
        <p>
            {{ post.content }}
        </p>
    </div>
</template>

<script>
export default {
    name: "Posts",

    props: [
        'post'
    ]
}
</script>

<style scoped>

</style>
