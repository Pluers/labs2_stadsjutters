<template>
    <div id="profile" v-if="user === 'notFound'">
        <h1>User not found</h1>
        <router-link :to="{ name: 'Home' }">
            <button class="secondary">
                Back Home
            </button>
        </router-link>
    </div>
    <div id="profile" v-else-if="user === 'loading'">
        <h1>Loading...</h1>
    </div>
    <div id="profile" v-else>
        <section>
            <img v-if="user && user.picture" :src="user.picture" class="profile_picture" alt="Profile Picture">
            <h2 v-if="user">{{ user.first_name }} {{ user.last_name }}</h2>
            <h5 v-if="user">{{ user.role }}</h5>
            <button class="secondary" v-if="currentUser.id == user.id || id == currentUser.id"
                v-on:click="this.$router.push({ name: 'EditProfile' })">Edit
                Profile</button>
            <button class="accent"
                v-if="user && (id === currentUser.id || currentUser.id == user.id) && user.role === 'jutter'"
                v-on:click="this.$router.push({ name: 'Admin' })">Admin
                Dashboard</button>
        </section>
        <hr>
        <section>
            <!-- All posts from user -->
            <template class="user-posts">
                <div class="loading" v-if="posts === null">
                    Loading...
                </div>
                <Post v-else v-for="post in (posts ? posts.slice(0, 10) : [])" :key="post.id" :post="post" />
            </template>
        </section>
    </div>
</template>

<script>
import { ref, onMounted, computed } from 'vue';
import { useRouter } from 'vue-router';
import Post from './components/Post.vue';
import axios from 'axios';

export default {

    components: {
        Post
    },
    setup() {
        const user = ref('loading');
        const currentUser = ref(null);
        const posts = ref(null);
        const router = useRouter();
        const id = computed(() => router.currentRoute.value.params.userid);

        const getUserData = async () => {
            try {
                let userPromise = id.value ? axios.get(`/api/user/${id.value}`) : Promise.resolve(null);
                let currentUserPromise = axios.get('/api/user');
                let postsPromise = axios.get('/api/post/getall');

                let [responseUser, responseCurrentUser, posts] = await Promise.all([userPromise, currentUserPromise, postsPromise]);

                return {
                    user: responseUser ? responseUser.data : null,
                    currentUser: responseCurrentUser.data,
                    posts: posts.data
                };
            } catch (error) {
                console.error('Failed to get user:', error);
            }
        };

        const getUser = async () => {
            try {
                let data = await getUserData();
                user.value = data.user;
                currentUser.value = data.currentUser;
            } catch (error) {
                console.error('Failed to get user:', error);
                return user.value = 'notFound';
            }
        };

        const getCurrentUser = async () => {
            try {
                let data = await getUserData();
                currentUser.value = data.currentUser;
                user.value = data.currentUser;
            } catch (error) {
                console.error('Failed to get user:', error);
            }
        };
        const getPosts = async () => {
            try {
                const userId = user.value ? user.value.id : currentUser.value.id;
                const response = await axios.get(`/api/post/user/get/${userId}`);
                if (response.status === 200) {
                    posts.value = response.data.sort((a, b) => new Date(b.created_on) - new Date(a.created_on));
                }
            } catch (error) {
                console.error('Failed to fetch posts:', error);
            }
        };

        onMounted(async () => {

            if (id.value) {
                await getUser();
            } else {
                await getCurrentUser();
            }
            getPosts();
        });

        return {
            user,
            currentUser,
            id: id.value,
            getUser,
            getCurrentUser,
            posts,
            getPosts,
        };
    },
};
</script>