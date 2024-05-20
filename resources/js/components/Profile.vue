<template>
    <h1>Profile</h1>
    <p v-if="user">Welcome to your profile page, {{ user.name }}!</p>
    <button v-on:click="logout">Logout</button>
</template>

<script>
import { ref, onMounted } from 'vue';
import axios from 'axios';

export default {
    setup() {
        const user = ref(null);

        const getUser = async () => {
            try {
                const response = await axios.get('/api/user', {
                    headers: {
                        'Authorization': `Bearer ${localStorage.getItem('token')}`
                    }
                });
                user.value = response.data;
                console.log(localStorage.getItem('token'));
            } catch (error) {
                console.error('Failed to get user:', error);
            }
        };

        onMounted(getUser);

        const logout = async () => {
            try {
                await axios.post('/logout');
                window.location.href = '/login';
            } catch (error) {
                console.error('Failed to log out:', error);
            }
        };

        return {
            user,
            logout,
        };
    },
};
</script>

<style scoped>
/* Your CSS here */
</style>