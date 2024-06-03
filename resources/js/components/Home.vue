<template>
    <div id="home">
        <button class="accent" v-on:click="this.$router.push('/post/new')">
            <!-- New post -->
            Nieuwe Post
        </button>
        <div id="filterElement">
            <div class="search">
                <input type="text" placeholder="Zoeken..." class="searchBar">
                </input>
                <a href="#">
                    <span class="material-symbols-rounded">search</span>
                </a>
            </div>
            <div class="filters">
                <div class="filter">
                    <!-- Filter -->
                    Filter
                </div>
                <div class="filter">
                    <!-- Filter -->
                    Filter
                </div>
                <div class="filter">
                    <!-- Filter -->
                    Filter
                </div>
            </div>
        </div>
        <div id="categories">
            <div class="category">
                <h3>New Posts</h3>
                <div class="new-posts">
                    <div class="post" v-if="posts === null">
                        Loading...
                        <div class="post-image">Loading...</div>
                        <div class="post-content">
                            <div class="post-header">
                                <h1 class="post-title">Loading...ㅤ</h1>
                                <p class="post-title">Loading...ㅤ</p>
                            </div>
                            <div class="post-body">
                                Loading...
                                Loading...
                                Loading...
                            </div>
                        </div>
                    </div>
                    <router-link v-for="post in (posts ? posts.slice(0, 5) : [])" :key="post.id"
                        :to="{ path: `/post/${post.id}`, params: { id: post.id } }" class="post">
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
            </div>
            <div class="category">
                <h3>Nearby</h3>
                <div class="nearby-posts">
                    <div class="post" v-if="posts === null">Loading...</div>
                    <router-link v-for="post in (posts ? posts.slice(0, 2) : [])" :key="post.id"
                        :to="{ path: `/post/${post.id}`, params: { id: post.id } }" class="post">
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
            </div>
        </div>
    </div>
</template>

<script>
import { ref, onMounted } from 'vue';
import axios from 'axios';

export default {
    setup() {
        const posts = ref(null);

        onMounted(async () => {
            try {
                const response = await axios.get('/api/post/getall');
                if (response.status === 200) {
                    const postsWithUser = await Promise.all(response.data.map(async post => {
                        const userResponse = await axios.get(`/api/user/${post.user_id}`);
                        if (userResponse.status === 200) {
                            post.user = userResponse.data;
                        }
                        return post;
                    }));
                    posts.value = postsWithUser.sort((a, b) => new Date(b.created_on) - new Date(a.created_on));
                }
            } catch (error) {
                console.error('Failed to fetch posts:', error);
            }
        });

        return {
            posts
        };
    },
};
</script>