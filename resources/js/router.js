import {createRouter, createWebHistory} from "vue-router";


const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        {
            path: '/login',
            name: 'user.login',
            component: () => import('./views/user/Login.vue')
        },
        {
            path: '/register',
            name: 'user.register',
            component: () => import('./views/user/Register.vue')
        },
        {
            path: '/users',
            name: 'users',
            component: () => import('./views/user/Index.vue')
        },
        {
            path: '/users/:id/posts',
            name: 'user.posts',
            component: () => import('./views/user/Show.vue')
        },
        {
            path: '/personal',
            name: 'user.personal',
            component: () => import('./views/user/Personal.vue'),
        },
        {
            path: '/feed',
            name: 'user.feed',
            component: () => import('./views/user/Feed.vue'),
        },
        {
            path: '/post/create',
            name: 'user.post.create',
            component: () => import('./views/user/post/Create.vue')
        }
    ]
})

router.beforeEach((to, from, next) => {
    let token = localStorage.getItem('x_xsrf_token')

    if (!token) {
        if (to.name === 'user.login' || to.name === 'user.register') {
            return next()
        } else {
            return next({name: 'user.login'})
        }
    }
    if (token) {
        if (to.name === 'user.login' || to.name === 'user.register') {
            return next({name: 'user.personal'})
        }
    }

    next();
});

export default router
