<template>
    <div class="p-8 w-96 mx-auto">
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
        <div class="flex justify-between">
            <div class="mt-3">
                <input ref="file" type="file" @change="uploadImage" hidden>
                <a href="#" class="mt-2 w-36 p-1.5 border border-blue-400 rounded-3xl bg-blue-400
                text-white hover:bg-white hover:text-blue-400 hover:border-blue-400"
                   @click.prevent="selectFile">Choose Image</a>
                <div v-if="preview" class="mt-4">
                    <img :src="preview" alt="">
                    <a href="#" @click.prevent="removePreview" class="underline text-blue-600">Cancel</a>
                </div>
            </div>
            <div>
                <button @click.prevent="store"
                        class="mt-2 w-36 p-1 border border-blue-400 rounded-3xl bg-blue-400 text-white
                    hover:bg-white hover:text-blue-400 hover:border-blue-400">
                    Publish
                </button>
            </div>
        </div>
    </div>
</template>

<script>

import axios from "axios";

export default {
    name: "Create",
    data() {
        return {
            title: '',
            content: '',
            preview: null,
            image: '',
            errors: []
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
                .then(res => {
                    this.title = ''
                    this.content = ''
                    this.image = null
                    this.preview = null
                    this.$router.push({name: 'user.personal'})
                })
                .catch(e => {
                        console.log(e);
                        this.errors = e.response.data.errors
                    }
                )
        }
    }
}
</script>

<style scoped>

</style>
