<template>
    <div>
        <h1>Edit User</h1>
        <form @submit.prevent="updateUser">
            <div>
                <label for="name">Name:</label>
                <input id="name" v-model="user.name" type="text" required>
            </div>
            <div>
                <label for="email">Email:</label>
                <input id="email" v-model="user.email" type="email" required>
            </div>
            <!-- Add more fields as needed -->
            <button class="primary" type="submit">Update</button>
        </form>
    </div>
</template>

<script>
import { ref, onMounted } from 'vue';
import axios from 'axios';

export default {
    setup() {
        // reactive reference to user
        const user = ref({
            name: '',
            email: '',
            // Add more fields as needed
        });

        // Get user information
        const getUser = async () => {
            try {
                // try a request to the server to get the user information only when the user is logged in and validated
                const response = await axios.get('/user');
                user.value = response.data;
            } catch (error) {
                console.error('Failed to get user:', error);
            }
        };

        // Update user information
        const updateUser = async () => {
            try {
                const response = await axios.put('/edit-profile', user.value);
                // Handle the response data
                console.log(response.data);
            } catch (error) {
                // Handle error
                console.error('Failed to update user:', error);
            }
        };

        // Call the getUser function when the component is mounted
        onMounted(getUser);

        // return the user and updateUser function to be used in the template
        return {
            user,
            updateUser,
        };
    },
};
</script>

<style scoped>
/* Your CSS here */
</style>