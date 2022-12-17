import './bootstrap';

import { createApp } from 'vue';
import router from './routes';
import ListItem from './layouts/components/ListItem.vue';
import ListView from './layouts/components/ListView.vue';
import Header from './layouts/components/Header.vue';
import Sidebar from './layouts/components/Sidebar.vue';
import ModalCreateProduct from './layouts/admin/components/ModalCreateProduct.vue';
import Pagination from './layouts/components/Pagination.vue';
import App from './layouts/App.vue';

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