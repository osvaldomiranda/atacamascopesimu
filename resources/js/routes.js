import App from './views/App'
import Vue from 'vue';
import VueRouter from 'vue-router'

import DashboardView   from './views/DashboardView'




Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/app',
            name: 'app',
            component: App,
        },
        {
            path: '/dasboard',
            name: 'dasboard',
            component: DashboardView,
        },
    ],
});



export default router;