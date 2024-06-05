<template>
    <div id="notFound">
        <h1>404 Not Found</h1>
        <p>The page you're looking for doesn't exist.</p>
        <router-link :to="{ name: 'Home' }">
            <button class="secondary">
                Back Home
            </button>
        </router-link>
    </div>
</template>

<script>
export default {
    name: 'NotFound',
};
</script>