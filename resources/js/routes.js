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
import ControlSimpleComponent   from './components/ControlSimpleComponent'




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
            path: '/gallery',
            name: 'Gallery',
            component: GalleryView,
        },


        {
            path: '/legal',
            name: 'Legal',
            component: LegalView,
        },


        {
            path: '/equipment',
            name: 'Equipment',
            component: EquipmentView,
        },

        {
            path: '/controlsimple',
            name: 'controlsimple',
            component: ControlSimpleComponent,
        },
    ],
});



export default router;