import { createRouter, createWebHistory } from 'vue-router';
import Auth from './Auth';
import Home from './components/home/Home.vue';
import Admin from './components/admin/Admin.vue';
import Login from './components/login/Login.vue';
import PageNotFound from './components/layouts/PageNotFound.vue';
import ProductDetail from './components/detail/ProductDetail.vue';
import ProductEdit from './components/edit/ProductEdit.vue';
import axios from 'axios';

const routes = [
    {
        path: '/',
        component: Home,
    },
    {
        path: '/admin',
        component: Admin,
        name: 'admin',
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/login',
        component: Login,
        name: 'login',
        meta: {
            redirectIfAuthenticated: true
        },
    },
    {
        path: '/product/detail/:id',
        component: ProductDetail,
        name: 'detail',
    },
    {
        path: '/product/edit/:id',
        component: ProductEdit,
        name: 'edit',
        meta: {
            requiresAuth: true,
        }
    },
    {
        path: '/:catchAll(.*)*',
        component: PageNotFound,
        name: 'pageNotFound'
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

router.beforeEach((to, from, next) => {
    const auth = Auth;
    auth.updateToken();
    if (to.matched.some(record => record.meta.requiresAuth)) {
        if (!auth.token) {
            router.push({ name: 'login', query: { redirect: to.fullPath } });
        } else {
            axios.get('/api/check_token')
                .then((response) => {
                    next();
                })
                .catch(error => {
                    router.push({ name: 'login', query: { redirect: to.fullPath } });
                });
        }
    } else if (to.matched.some(record => record.meta.redirectIfAuthenticated)) {
        if (auth.token) {
            axios.get('/api/check_token')
                .then((response) => {
                    router.push({ name: 'admin' });
                })
                .catch(error => {
                    router.push({ name: 'login', query: { redirect: to.fullPath } });
                });
        } else {
            next();
            return;
        }
    } else {
        next();
    }
});

axios.interceptors.response.use(undefined, function (error) {
    if (error) {
        const originalRequest = error.config;
        if (error.response.status === 401 && !originalRequest._retry) {
            originalRequest._retry = true;
            Auth.logout();
            return router.push({ name: 'login', query: { redirect: window.location.pathname }});
        }
    }
    return Promise.reject(error);
})

export default router;