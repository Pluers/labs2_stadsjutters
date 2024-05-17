import { createRouter, createWebHistory } from 'vue-router';
import Home from './components/Home.vue';
import Map from './components/Map.vue';
import Profile from './components/Profile.vue';
import Settings from './components/Settings.vue';
import Notifications from './components/Notifications.vue';

const routes = [
    { path: '/', component: Home, meta: { title: 'Home' } },
    { path: '/map', component: Map, meta: { title: 'Map' } },
    { path: '/profile', component: Profile, meta: { title: 'Profile' } },
    { path: '/settings', component: Settings, meta: { title: 'Settings' } },
    { path: '/notifications', component: Notifications, meta: { title: 'Notifications' } },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.afterEach((to) => {
    document.title = to.meta.title || 'Default Title';
});

export default router;