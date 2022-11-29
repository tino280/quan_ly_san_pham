import './bootstrap';

import { createApp } from 'vue';
import router from './routes';
import ListItem from './components/layouts/ListItem.vue';
import ListView from './components/layouts/ListView.vue';
import Header from './components/layouts/header.vue';
import Sidebar from './components/layouts/Sidebar.vue';
import ModalCreateProduct from './components/admin/components/ModalCreateProduct.vue';
import Pagination from './components/layouts/Pagination.vue';
import App from './components/App.vue';

const app = createApp({});

app.component('App', App);
app.component('list-item', ListItem);
app.component('list-view', ListView);
app.component('Header', Header);
app.component('Sidebar', Sidebar);
app.component('modal-create-product', ModalCreateProduct);
app.component('pagination', Pagination);

app.use(router);

app.mount('#app');