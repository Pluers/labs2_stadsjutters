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
            <div class="category">
                <h3>Nearby</h3>
                <div class="new-posts">
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
export default {
    data() {
        return {
            // Your data here
        };
    },
    methods: {
        // Your methods here
    },
};
</script>