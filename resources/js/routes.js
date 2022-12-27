import { createRouter, createWebHistory } from 'vue-router';
import Auth from './Auth';
import Home from './layouts/home/Home.vue';
import Admin from './layouts/admin/Admin.vue';
import Login from './layouts/login/Login.vue';
import PageNotFound from './layouts/components/PageNotFound.vue';
import ProductDetail from './layouts/detail/ProductDetail.vue';
import ProductEdit from './layouts/edit/ProductEdit.vue';
import axios from 'axios';
import Swal from "sweetalert2";

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
            requirePermission: true,
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
    routes,
    scrollBehavior(to, from, savePosition) {
        return savePosition || {top: 0};
    }
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
                    if (to.matched.some(record => record.meta.requirePermission)) {
                        axios.post(`/api/products/update/${to.params.id}`)
                            .then(response => {
                                next();
                            })
                            .catch(error => {
                                Swal.fire({
                                    icon: 'error',
                                    title: `${error.response.data.message}`
                                });
                                return;
                            })
                    } else {
                        next();
                    }
                })
                .catch(error => {
                    router.push({ name: 'login', query: { redirect: to.fullPath } });
                });
        }
    }
    else if (to.matched.some(record => record.meta.redirectIfAuthenticated)) {
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

export default router;
