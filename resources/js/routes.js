import App from './views/App'
import Vue from 'vue';
import VueRouter from 'vue-router'

import OffersView        from './views/OffersView'
import UsersView         from './views/UsersView'
import StatisticsView    from './views/StatisticsView'
import EquipmentView     from './views/EquipmentView'
import AdminControlView  from './views/AdminControlView'

import DashboardView     from './views/DashboardView'
import ReservationView   from './views/ReservationView'
import PointsView        from './views/PointsView'
import PublicationsView  from './views/PublicationsView'
import GalleryView        from './views/GalleryView'
import WeatherView        from './views/WeatherView'
import ContactView        from './views/ContactView'
import LegalView        from './views/LegalView'


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
            path: '/reservations',
            name: 'Reservations',
            component: ReservationView,
        },
        {
            path: '/points',
            name: 'Points',
            component: PointsView,
        },
        {
            path: '/publications',
            name: 'Publications',
            component: PublicationsView,
        },
        {
            path: '/gallery',
            name: 'Gallery',
            component: GalleryView,
        },
        {
            path: '/weather',
            name: 'Weather',
            component: WeatherView,
        },
        {
            path: '/contacts',
            name: 'Contacts',
            component: ContactView,
        },

        {
            path: '/legal',
            name: 'Legal',
            component: LegalView,
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
        {
            path: '/admincontrol',
            name: 'AdminControl',
            component: AdminControlView,
        },
    ],
});



export default router;