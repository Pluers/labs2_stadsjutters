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
                    <div class="post" v-for="post in posts.slice(0, 5)" :key="post.id">
                        <img :src="post.image" alt="">
                        <div class="post-content">
                            <div class="post-header">
                                <h1 class="post-title">{{ post.title }}</h1>
                                <p class="post-title">{{ post.tags }}</p>
                            </div>
                            <div class="post-body">
                                {{ post.body }}
                                {{ post.user.first_name }} {{ post.user.last_name }}
                                {{ new Date(post.created_at).toLocaleDateString() }}
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="category">
                <h3>Nearby</h3>
                <div class="nearby-posts">
                    <div class="post" v-for="i in 3" :key="i">
                        <img src="" alt="">
                        <div class="post-header">
                            <div class="post-title">
                                <!-- Post title -->
                                Post titel
                            </div>
                            <div class="post-date">
                                <!-- Post date -->
                                Post datum
                            </div>
                            <div class="post-content">
                                <!-- Post content -->
                                Post inhoud
                            </div>
                        </div>
                    </div>
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
        const posts = ref([]);

        onMounted(async () => {
            try {
                const response = await axios.get('/api/post/getall');
                if (response.status === 200) {
                    posts.value = response.data.sort((a, b) => new Date(b.created_on) - new Date(a.created_on));
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