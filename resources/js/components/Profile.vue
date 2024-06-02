<template>
    <div id="profile">
        <section>
            <img src="{{ user.picture }}" alt="Profile Picture Missing">
            <h2 v-if="user">{{ user.first_name }}</h2>
            <p v-if="user">{{ user.role }}</p>

            <button class="secondary" v-on:click="this.$router.push('/edit-profile')">Edit Profile</button>
            <hr>
            <!-- All posts from user -->
        </section>
        <button class="secondary" v-on:click="logout">Logout</button><!--Should be moved to settings later-->
    </div>

</template>

<script>
import { ref, onMounted } from 'vue';
import axios from 'axios';

export default {
    setup() {
        // reactive reference to user
        const user = ref(null);

        // Get user information
        const getUser = async () => {
            try {
                // try a request to the server to get the user information only when the user is logged in and validated
                const response = await axios.get('/api/user');
                user.value = response.data;
            } catch (error) {
                console.error('Failed to get user:', error);
            }
        };

        // Call the getUser function when the component is mounted
        onMounted(getUser);

        // Log out the user by redirecting to the logout page where the logout function takes care of the rest
        const logout = async () => {
            try {
                await axios.post('/logout');
                window.location.href = '/login';
            } catch (error) {
                console.error('Failed to log out:', error);
            }
        };

        // return the user and logout function to be used in the template
        return {
            user,
            logout,
        };
    },
};
</script>