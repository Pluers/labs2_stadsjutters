<template>
    <div id="home">
        <button class="accent" v-on:click="this.$router.push({ name: 'NewPost' })">
            <!-- New post -->
            Nieuwe Post
        </button>
        <div id="filterElement">
            <div class="search">
                <input type="text" placeholder="Zoeken..." class="searchBar" v-model="searchTerm">
                </input>
                <div>
                    <span class="material-symbols-rounded">search</span>
                </div>
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
        <div v-if="searchTerm != ''" id="searchResults">
            <div class="category">
                <h2>Search Results</h2>
                <div class="search-posts">
                    <div class="loading" v-if="posts === null">
                        Loading...
                    </div>
                    <Post v-for="post in (posts ? posts : [])" :key="post.id" :post="post" class="search_result" />
                </div>
            </div>
        </div>
        <div v-else id="categories">
            <div class="category">
                <h2>New Posts</h2>
                <div class="new-posts">
                    <div class="loading" v-if="newPosts === null">
                        Loading...
                    </div>
                    <Post v-else v-for="post in (newPosts ? newPosts.slice(0, 5) : [])" :key="post.id" :post="post" />
                </div>
            </div>
            <div class="category">
                <h2>Nearby</h2>
                <div class="nearby-posts">
                    <div class="loading" v-if="nearbyPosts === null">
                        Loading...
                    </div>
                    <Post v-else v-for="post in (nearbyPosts ? nearbyPosts.slice(0, 5) : [])" :key="post.id"
                        :post="post" />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Post from './components/Post.vue';
import { ref, onMounted, watch } from 'vue';
import axios from 'axios';

export default {
    components: {
        Post
    },
    setup() {
        const newPosts = ref(null);
        const nearbyPosts = ref(null);
        const posts = ref(null);
        const searchTerm = ref('');
        let allPosts = ref(null);

        onMounted(async () => {
            try {
                const response = await axios.get('/api/post/getall');
                if (response.status === 200) {
                    allPosts = response.data
                    posts.value = [...allPosts];
                    newPosts.value = [...posts.value].sort((a, b) => new Date(b.created_at) - new Date(a.created_at));
                    nearbyPosts.value = [...posts.value].sort((a, b) => a.location.localeCompare(b.location));
                    searchPosts();
                }
            } catch (error) {
                console.error('Failed to fetch posts:', error);
            }
        });

        const searchPosts = () => {
            try {
                if (!searchTerm.value) {
                    posts.value = allPosts;
                } else {
                    posts.value = allPosts.filter(post =>
                        (typeof post.title === 'string' && post.title.toLowerCase().includes(searchTerm.value.toLowerCase())) ||
                        (typeof post.body === 'string' && post.body.toLowerCase().includes(searchTerm.value.toLowerCase()))
                    );
                    console.log(posts.value);
                }
            } catch (error) {
                console.error('Error in searchPosts:', error);
            }
        };

        watch(searchTerm, searchPosts);

        return {
            newPosts,
            nearbyPosts,
            posts,
            searchTerm,
            searchPosts
        };
    },
};
</script>