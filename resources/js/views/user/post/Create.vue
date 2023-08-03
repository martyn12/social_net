<template>
    <div class="p-8 w-96 mx-auto">
        <div>
            <input type="text" placeholder="title" v-model="title"
                   class="border rounded-full border-stone-400 p-1 w-96">
        </div>
        <div>
            <textarea type="text" placeholder="content" v-model="content"
                      class="mt-2 border rounded-3xl border-stone-400 p-1 w-96"></textarea>
        </div>
        <div class="flex justify-between">
            <div class="mt-3">
                <input ref="file" type="file" @change="uploadImage" hidden>
                <a href="#" class="mt-2 w-36 p-1.5 border-blue-400 rounded-3xl bg-blue-400 text-white"
                   @click.prevent="selectFile">Choose Image</a>
                <div v-if="preview" class="mt-4">
                    <img :src="preview" alt="">
                    <button @click.prevent="removePreview" class="mt-5 w-36 p-1 border border-blue-400 rounded-3xl bg-blue-400 text-white">Remove</button>
                </div>
            </div>
            <div class="">
                <button @click.prevent="store"
                    class="mt-2 w-36 p-1 border border-blue-400 rounded-3xl bg-blue-400 text-white hover:bg-white hover:text-blue-400 hover:border-blue-400">
                    Publish
                </button>
            </div>
        </div>
    </div>
</template>

<script>

import Index from "@/views/Index.vue";
import axios from "axios";

export default {
    name: "Create",
    components: {Index},
    data() {
        return {
            title: '',
            content: '',
            preview: null,
            image: null
        }
    },

    methods: {
        selectFile() {
            this.fileInput = this.$refs.file;
            this.fileInput.click();
        },

        uploadImage(e) {
            const file = e.target.files[0];
            const fileReader = new FileReader();
            fileReader.readAsDataURL(file);
            fileReader.onload = e => {
                this.preview = e.target.result
            }
            this.image = file;
        },

        removePreview() {
            this.preview = null;
            this.image = null;
        },

        store() {
            const formData = new FormData();
            formData.append('image', this.image);
            formData.append('title', this.title);
            formData.append('content', this.content);
            axios.post('/api/post', formData)
                .then( res => {
                    console.log(res);
                })
                .catch(err => {
                    console.log(err);
                })
        }
    }
}
</script>

<style scoped>

</style>
