<template>
    <div class="flex place-content-center">
        <div class="box-border rounded-3xl border p-32 backdrop-brightness-95 mt-24">
            <div class="mt-auto block">
                <!-- <label for="">Name</label> -->
                <input v-model="name" type="text" placeholder="Enter your name" class="rounded-full border p-2 mx-auto" />
            </div>
            <div class="mt-3 block">
                <!-- <label for="">Email</label> -->
                <input v-model="email" type="email" placeholder="Enter your email" class="rounded-full border p-2" />
            </div>
            <div class="mt-3">
                <!-- <label for="">Password</label> -->
                <input v-model="password" type="password" placeholder="Create your password" class="rounded-full border p-2" />
            </div>
            <div class="mt-3">
                <!-- <label for="">Password confirmation</label> -->
                <input v-model="password_confirmation" type="password" placeholder="Confirm password" class="rounded-full border p-2" />
            </div>
            <div class="mt-3">
                <button class="text-white w-32 rounded-full border border-blue-400 bg-blue-400 p-2 hover:bg-green-400 hover:border-green-400 text-center">Sign up</button>
            </div>
        </div>
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
