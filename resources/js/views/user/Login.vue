<template>
    <router-link :to="{name: 'user.register'}">Register</router-link>
    <div>
        <input type="text" class="font-mono" v-model="email" placeholder="email">
    </div>
    <div>
        <input type="password" v-model="password" placeholder="password">
    </div>
    <div>
        <button @click.prevent="login">
            Login
        </button>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "Login",

    data() {
        return {
            email: null,
            password: null
        }
    },

    methods: {
        login() {
            axios.get('/sanctum/csrf-cookie').then(response => {
                axios.post('/login', {
                    email: this.email,
                    password: this.password
                })
                    .then(res => {
                        console.log(res);
                        localStorage.setItem('x_xsrf_token', res.config.headers['X-XSRF-TOKEN'])
                        this.$router.push({name: 'user.personal'})
                    })
                    .catch(err => {
                        console.log(err);
                    })
            });
        }
    }
}
</script>

<style scoped>

</style>
