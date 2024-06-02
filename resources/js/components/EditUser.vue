<template>
    <div>
        <h1>Edit User</h1>
        <form @submit.prevent="updateUser">
            <div>
                <label for="first_name">First name:</label>
                <input id="first_name" v-model="user.first_name" type="text" required>
            </div>
            <div>
                <label for="last_name">Last name:</label>
                <input id="last_name" v-model="user.last_name" type="text" required>
            </div>
            <div>
                <label for="email">Email:</label>
                <input id="email" v-model="user.email" type="email" required>
            </div>
            <button class="primary" type="submit">Update</button>
        </form>
    </div>
</template>

<script>
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import axios from 'axios';

export default {
    setup() {
        const router = useRouter();
        const user = ref({
            first_name: '',
            last_name: '',
            email: '',
        });

        const getUser = async () => {
            try {
                const response = await axios.get('/api/user');
                user.value = response.data;
            } catch (error) {
                console.error('Failed to get user:', error);
            }
        };

        const updateUser = async () => {
            try {
                const response = await axios.put('/edit-profile', user.value);
                console.log(response.data);
                router.push(`/profile`);
            } catch (error) {
                console.error('Failed to update user:', error);
            }
        };

        onMounted(getUser);

        return {
            user,
            updateUser,
        };
    },
};
</script>