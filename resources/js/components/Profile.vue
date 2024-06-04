<template>
    <div id="profile">
        <div v-if="user === 'loading'">
            <h1>Loading...</h1>
        </div>
        <section>
            <img v-if="user && user.picture" :src="user.picture" alt="Profile Picture">
            <h2 v-if="user">{{ user.first_name }}</h2>
            <p v-if="user">{{ user.role }}</p>
            <p v-if="user">{{ id }} {{ user.id }}</p>
            <button class="secondary" v-if="id == currentUser.id || currentUser"
                v-on:click="this.$router.push('/edit-profile')">Edit
                Profile</button>
            <button class="accent" v-if="user && id === user.id && user.role === 'jutter'"
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
                let user = await axios.get(`/api/user/${id.value}`);
                let currentUser = await axios.get('/api/user');
                return user, currentUser;
            } catch (error) {
                console.error('Failed to get user:', error);
            }
        };

        const getUser = async () => {
            try {
                const { user, currentUser } = getUserData();
                user.value = user.data;
                currentUser.value = currentUser.data;
            } catch (error) {
                console.error('Failed to get user:', error);
            }
        };

        const getCurrentUser = async () => {
            try {
                const { currentUser } = getUserData();
                user.value = currentUser.data;
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
            console.log('getCurrentUser response:', currentUser.value); // Log the response
        });

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