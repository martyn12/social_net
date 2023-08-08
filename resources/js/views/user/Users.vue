<template>
    <div v-if="users" class="block p-8 w-96 mx-auto">
        <div v-for="user in users" class="my-10 block border-b border-neutral-300 p-3 shadow rounded-b-xl">
            <h3 class="text-2xl my-3">
                {{ user.name }}
            </h3>
            <p>
                {{ user.email }}
            </p>
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
                .then( res => {
                    this.users = res.data.data
                })
        }
    }
}
</script>

<style scoped>

</style>
