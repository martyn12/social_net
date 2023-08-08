<template>
<div class="flex justify-between p-8 w-96 mx-auto">
    <router-link :to="{name: 'user.login'}" v-if="!token">Login</router-link>
    <router-link :to="{name: 'users'}" v-if="token">Users</router-link>
    <a href="#" @click.prevent="logout" v-if="token">Logout</a>
    <router-link :to="{name: 'index'}" v-if="token">index</router-link>
    <router-link :to="{name: 'random'}" v-if="token">random</router-link>
    <router-link :to="{name: 'user.personal'}" v-if="token">personal</router-link>
</div>
    <router-view></router-view>
</template>

<script>
import axios from "axios";

export default {
    name: "App",

    data() {
        return {
            token:null
        }
    },

    mounted() {
        this.getToken()
    },

    watch: {
        $route(to, from) {
            this.getToken()
        }
    },

    methods: {

        getToken() {
            this.token = localStorage.getItem('x_xsrf_token')
        },
        logout() {
            axios.post('/logout')
                .then( res => {
                    localStorage.removeItem('x_xsrf_token')
                    this.$router.push({name: 'user.login'})
                })
        },
    }
}
</script>

<style scoped>

</style>
