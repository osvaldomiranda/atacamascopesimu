import App from './views/App'
import Vue from 'vue';
import VueRouter from 'vue-router'

import DashboardView   from './views/DashboardView'
import ChatComponent   from './components/ChatComponent'
import AppComponent   from './components/AppComponent'




Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/app',
            name: 'app',
            component: AppComponent,
        },
        {
            path: '/dashboard',
            name: 'dashboard',
            component: DashboardView,
        },
        {
            path: '/chat',
            name: 'chat',
            component: ChatComponent,
        },
    ],
});



export default router;