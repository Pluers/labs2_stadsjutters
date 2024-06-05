import { createRouter, createWebHistory } from 'vue-router';
import axios from 'axios';

import Home from './components/Home.vue';
import Map from './components/Map.vue';
import Profile from './components/Profile.vue';
import UserProfile from './components/Profile.vue';
import Settings from './components/Settings.vue';
import Notifications from './components/Notifications.vue';
import Admin from './components/Admin.vue';
import NotFound from './components/NotFound.vue';

import EditUser from './components/EditUser.vue';

import ShowPost from './components/posts/ShowPost.vue';
import CreatePost from './components/posts/CreatePost.vue';
import EditPost from './components/posts/EditPost.vue';

const routes = [
    { path: '/', name: 'Home', component: Home, meta: { title: 'Home' } },
    { path: '/home', redirect: '/' },
    { path: '/map', name: 'Map', component: Map, meta: { title: 'Map' } },
    { path: '/profile', name: 'Profile', component: Profile, meta: { title: 'Profile' } },
    { path: '/profile/:userid', name: 'UserProfile', component: UserProfile, meta: { title: ':username' } },
    { path: '/settings', name: 'Settings', component: Settings, meta: { title: 'Settings' } },
    { path: '/notifications', name: 'Notifications', component: Notifications, meta: { title: 'Notifications' } },
    { path: '/edit-profile', name: 'EditProfile', component: EditUser, meta: { title: 'Edit User' } },
    { path: '/post/new', name: 'NewPost', component: CreatePost, meta: { title: 'Create Post' } },
    { path: '/post/:postid', name: 'Post', component: ShowPost, meta: { title: ':postname' } },
    { path: '/post/edit/:postid', name: 'EditPost', component: EditPost, meta: { title: 'Edit Post' } },
    { path: '/admin', name: 'Admin', component: Admin, meta: { title: 'Admin Dashboard', requiresAuth: true, isAdmin: true } },
    { path: '/:pathMatch(.*)*', name: '404', name: 'not-found', component: NotFound },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});
router.beforeEach(async (to, from, next) => {
    if (to.meta.title) {
        document.title = to.meta.title;
    }
    if (to.matched.some(record => record.meta.isAdmin)) {
        const response = await axios.get('/api/user');
        const user = response.data;
        if (user && user.role === 'jutter') {
            next();
        } else {
            next({ path: '/home' });
        }
    } else {
        next(); // proceed as normal if route does not require admin access
    }
});

export default router;