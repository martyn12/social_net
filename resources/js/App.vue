<template>
<div class="flex justify-between p-8 w-96 mx-auto">
    <router-link :to="{name: 'users'}" v-if="token">Users</router-link>
    <router-link :to="{name: 'user.feed'}" v-if="token">Feed</router-link>
    <router-link :to="{name: 'user.personal'}" v-if="token">Personal</router-link>
    <a href="#" @click.prevent="logout" v-if="token">Logout</a>
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
