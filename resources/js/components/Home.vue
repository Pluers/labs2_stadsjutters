<template>
    <div id="home">
        <button class="accent" v-on:click="this.$router.push({ name: 'NewPost' })">
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
                    <div class="loading" v-if="newPosts === null">
                        Loading...
                    </div>
                    <router-link v-for="post in (newPosts ? newPosts.slice(0, 5) : [])" :key="post.id"
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
            </div>
            <div class="category">
                <h3>Nearby</h3>
                <div class="nearby-posts">
                    <div class="loading" v-if="posts === null">Loading...</div>
                    <router-link v-for="post in (posts ? posts.slice(0, 2) : [])" :key="post.id"
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
            </div>
        </div>
    </div>
</template>

<script>
import { ref, onMounted } from 'vue';
import axios from 'axios';

export default {
    setup() {
        const newPosts = ref(null);
        const posts = ref(null);

        onMounted(async () => {
            try {
                const response = await axios.get('/api/post/getall');
                if (response.status === 200) {
                    newPosts.value = response.data.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));
                    posts.value = response.data.sort((a, b) => a.location.localeCompare(b.location));
                }
            } catch (error) {
                console.error('Failed to fetch posts:', error);
            }
        });

        return {
            newPosts,
            posts
        };
    },
};
</script>