<template>
    <div id="home">
        <button class="accent">
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
        <div class="posts">
            <div class="post">
                <div class="post-header">
                    <div class="post-title">
                        <!-- Post title -->
                        Post titel
                    </div>
                    <div class="post-date">
                        <!-- Post date -->
                        Post datum
                    </div>
                </div>
                <div class="post-content">
                    <!-- Post content -->
                    Post inhoud
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