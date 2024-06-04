<template>
    <div id="profile">
        <div v-if="user === 'loading'">
            <h1>Loading...</h1>
        </div>
        <section v-else>
            <img v-if="user && user.picture" :src="user.picture" alt="Profile Picture">
            <h2 v-if="user">{{ user.first_name }}</h2>
            <p v-if="user">{{ user.role }}</p>
            <p v-if="user">url id: {{ id }}</p>
            <p v-if="user">posts user id: {{ user.id }}</p>
            <p v-if="user">current logged in user: {{ currentUser.id }}</p>
            <button class="secondary" v-if="currentUser.id == user.id || id == currentUser.id"
                v-on:click="this.$router.push('/edit-profile')">Edit
                Profile</button>
            <button class="accent"
                v-if="user && (id === currentUser.id || currentUser.id == user.id) && user.role === 'jutter'"
                v-on:click="this.$router.push('/admin')">Admin
                Dashboard</button>
            <hr>
            <!-- All posts from user -->
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
        const router = useRouter();

        const id = computed(() => router.currentRoute.value.params.userid);

        const getUserData = async () => {
            try {
                let responseUser = id.value ? await axios.get(`/api/user/${id.value}`) : null;
                let responseCurrentUser = await axios.get('/api/user');
                return { user: responseUser ? responseUser.data : null, currentUser: responseCurrentUser.data };
            } catch (error) {
                console.error('Failed to get user:', error);
            }
        };

        const getUser = async () => {
            try {
                let data = await getUserData();
                user.value = data.user;
                currentUser.value = data.currentUser;
                console.log('getUser response:', currentUser.value); // Log the response
            } catch (error) {
                console.error('Failed to get user:', error);
            }
        };

        const getCurrentUser = async () => {
            try {
                let data = await getUserData();
                currentUser.value = data.currentUser;
                user.value = data.currentUser;
                console.log('getCurrentUser response:', currentUser.value); // Log the response
            } catch (error) {
                console.error('Failed to get user:', error);
            }
        };

        onMounted(async () => {
            if (id.value) {
                await getUser();
            } else {
                await getCurrentUser();
            }
            console.log(currentUser.value); // Log the value after the functions have resolved
        });

        console.log(user.value, currentUser.value); // Access the values outside the functions

        return {
            user,
            currentUser,
            id: id.value,
            getUser,
            getCurrentUser,
        };
    },
};
</script>