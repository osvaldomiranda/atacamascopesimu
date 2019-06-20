import App from './views/App'
import Vue from 'vue';
import VueRouter from 'vue-router'

import DashboardView    from './views/DashboardView'
import OffersView       from './views/OffersView'
import PublicationsView from './views/PublicationsView'
import UsersView        from './views/UsersView'
import StatisticsView   from './views/StatisticsView'
import EquipmentView   from './views/EquipmentView'

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
        {
            path: '/offers',
            name: 'offers',
            component: OffersView,
        },
        {
            path: '/publications',
            name: 'Publications',
            component: PublicationsView,
        },
        {
            path: '/users',
            name: 'Users',
            component: UsersView,
        },
        {
            path: '/statistics',
            name: 'Statistics',
            component: StatisticsView,
        },
        {
            path: '/equipment',
            name: 'Equipment',
            component: EquipmentView,
        },
    ],
});



export default router;