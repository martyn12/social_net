<template>
    <div>
        <input type="text" v-model="name" placeholder="name">
    </div>
    <div>
        <input type="text" v-model="email" placeholder="email">
    </div>
    <div>
        <input type="password" v-model="password" placeholder="password">
    </div>
    <div>
        <input type="password" v-model="password_confirmation" placeholder="password_confirmation">
    </div>
    <div>
        <button @click.prevent="register">
            Register
        </button>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "Register",

    data() {
        return {
            name: null,
            email: null,
            password: null,
            password_confirmation: null
        }
    },

    methods: {
        register() {
            axios.get('/sanctum/csrf-cookie').then(response => {
                axios.post('/register', {
                    name: this.name,
                    email: this.email,
                    password: this.password,
                    password_confirmation: this.password_confirmation,
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
