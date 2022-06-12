import Vue from 'vue'
import VueRouter from 'vue-router'
import Dashboard from '../pages/Dashboard';
import Tour from '../pages/Tour';
import Booking from '../pages/Booking';
import Bookings from '../pages/Bookings';

Vue.use(VueRouter);

const router = new VueRouter({
    linkActiveClass: 'active',
    mode: 'history',
    routes: [
        {
            path: '/',
            component: Dashboard,
            name: 'Dashboard',
        },
        {
            path: '/tour',
            component: Tour,
            name: 'Tour'
        },
        {
            path: '/booking/:id',
            component: Booking,
            name: 'Booking'
        },
        {
            path: '/bookings',
            component: Bookings,
            name: 'Bookings'
        },
    ]
});

export default router;
