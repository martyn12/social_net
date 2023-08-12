<template>
    <div v-if="users" class="block p-8 w-96 mx-auto">
        <div v-for="user in users" class="flex justify-between items-center my-10 block border-b border-neutral-300 p-3">
            <router-link :to="{name: 'user.posts', params: {id: user.id}}">
                <h3 class="text-2xl mb-3">
                    {{ user.name }}
                </h3>
                <p>
                    {{ user.email }}
                </p>
            </router-link>
            <div>
                <a @click.prevent="follow(user)" href="#"
                   :class="['mt-2 w-64 py-2 px-7 border border-blue-400 rounded-3xl',
                    user.is_followed ? 'bg-white text-blue-400' : 'bg-blue-400 text-white']">
                    {{user.is_followed ? 'Unfollow' : 'Follow'}}</a>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "Users",

    data() {
        return {
            users: []
        }
    },

    mounted() {
        this.getUsers()
    },

    methods: {
        getUsers() {
            axios.get('/api/users')
                .then(res => {
                    this.users = res.data.data
                })
        },

        follow(user) {
            axios.post(`/api/users/${user.id}/follow`)
                .then( res => {
                    user.is_followed = res.data.is_followed;
                })
        }
    }
}
</script>

<style scoped>

</style>
