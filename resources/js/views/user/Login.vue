<template>
    <div class="flex place-content-center">
        <div class="box-border rounded-3xl border p-32 backdrop-brightness-95 mt-24">
            <div class="mt-3 block">
                <!-- <label for="">Email</label> -->
                <input v-model="email" type="email" placeholder="Enter your email" class="rounded-full border p-2" />
            </div>
            <div class="mt-3">
                <!-- <label for="">Password</label> -->
                <input v-model="password" type="password" placeholder="Enter your password" class="rounded-full border p-2" />
            </div>
            <div class="mt-3">
                <button @click.prevent="login" class="text-white w-32 rounded-full border border-blue-400 bg-blue-400 p-2 hover:bg-green-400 hover:border-green-400 text-center">Sign in</button>
            </div>
            <div class="mt-3 flex justify-between">
                <div class="mr-3">
                    Dont have an account yet?
                </div>
                <a href="/register" class="underline text-blue-600">Register</a>
            </div>
        </div>
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
