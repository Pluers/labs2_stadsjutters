<template>
    <div class="overlay"></div> <!-- This is the pill-shaped overlay. -->
    <router-link to="/">
        <span class="material-symbols-rounded">
            home
        </span>
        <p>Home</p>
    </router-link>
    <router-link to="/map">
        <span class="material-symbols-rounded">
            map
        </span>
        <p>Map</p>
    </router-link>
    <router-link to="/profile">
        <span class="material-symbols-rounded">
            person
        </span>
        <p>Profile</p>
    </router-link>
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

<style scoped>
/* Your CSS here */
</style>