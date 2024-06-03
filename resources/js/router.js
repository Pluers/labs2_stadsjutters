import { createRouter, createWebHistory } from 'vue-router';
import Home from './components/Home.vue';
import Map from './components/Map.vue';
import Profile from './components/Profile.vue';
import Settings from './components/Settings.vue';
import Notifications from './components/Notifications.vue';
import NotFound from './components/NotFound.vue';

import EditUser from './components/EditUser.vue';

import ShowPost from './components/posts/ShowPost.vue';
import CreatePost from './components/posts/CreatePost.vue';
import EditPost from './components/posts/EditPost.vue';

const routes = [
    { path: '/', component: Home, meta: { title: 'Home' } },
    { path: '/home', redirect: '/' },
    { path: '/map', component: Map, meta: { title: 'Map' } },
    { path: '/profile', component: Profile, meta: { title: 'Profile' } },
    { path: '/settings', component: Settings, meta: { title: 'Settings' } },
    { path: '/notifications', component: Notifications, meta: { title: 'Notifications' } },
    { path: '/edit-profile', component: EditUser, meta: { title: 'Edit User' } },
    { path: '/post/new', component: CreatePost, meta: { title: 'Create Post' } },
    { path: '/post/:postid', component: ShowPost, meta: { title: ':postname' } },
    { path: '/post/edit/:postid', component: EditPost, meta: { title: 'Edit Post' } },
    { path: '/:pathMatch(.*)*', name: 'not-found', component: NotFound },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});
router.afterEach((to) => {
    if (to.meta.title) {
        document.title = to.meta.title;
    }
});

export default router;