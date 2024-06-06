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
            <img v-if="user && user.picture" :src="user.picture" alt="Profile Picture">
            <h2 v-if="user">{{ user.first_name }}</h2>
            <p v-if="user">{{ user.role }}</p>
            <p v-if="user">url id: {{ id }}</p>
            <p v-if="user">posts user id: {{ user.id }}</p>
            <p v-if="user">current logged in user: {{ currentUser.id }}</p>
            <button class="secondary" v-if="currentUser.id == user.id || id == currentUser.id"
                v-on:click="this.$router.push('EditProfile')">Edit
                Profile</button>
            <button class="accent"
                v-if="user && (id === currentUser.id || currentUser.id == user.id) && user.role === 'jutter'"
                v-on:click="this.$router.push('Admin')">Admin
                Dashboard</button>
        </section>
        <hr>
        <section>
            <!-- All posts from user -->
            <div class="user-posts">
                <div class="loading" v-if="posts === null">
                    Loading...
                </div>
                <router-link v-for="post in (posts ? posts.slice(0, 5) : [])" :key="post.id"
                    :to="{ name: 'Post', params: { postid: post.id } }" class="post">
                    <img class="post-image" :src="post.image" alt="" />
                    <div class="post-content">
                        <div class="post-header">
                            <h1 class="post-title">{{ post.title }}</h1>
                            <p class="post-title">{{ post.tags }}</p>
                        </div>
                        <div class="post-body">
                            {{ post.body }}
                            {{ post.user ? `${post.user.first_name} ${post.user.last_name}` : 'User not found' }}
                            {{ new Date(post.created_at).toLocaleDateString() }}
                        </div>
                    </div>
                </router-link>
            </div>
        </section>
    </div>
</template>

<script>
import { ref, onMounted, computed } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router'; // import useRouter

export default {
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