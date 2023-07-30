<template>
<div>
    Personal
</div>
</template>

<script>
import axios from "axios";

export default {
    name: "Personal",
    data() {
        return {
            token: null
        }
    },

    mounted() {
        this.getToken()
    },

    methods: {
        getToken() {
            this.token = localStorage.getItem('x_xsrf_token')
        }
    }
}
</script>

<style scoped>

</style>
