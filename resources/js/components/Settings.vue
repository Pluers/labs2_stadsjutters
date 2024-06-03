<template>
    <div id="settings">
        <section>
            <h2>Account</h2>
            <p>Delete account</p>
            <button class="secondary" v-on:click="logout">Logout</button><!--Should be moved to settings later-->
        </section>
        <hr>
    </div>

</template>

<script>
import { ref, onMounted } from 'vue';
import axios from 'axios';

export default {
    data() {
        const logout = async () => {
            try {
                await axios.post('/logout');
                window.location.href = '/login';
            } catch (error) {
                console.error('Failed to log out:', error);
            }
        };

        return {
            logout,
        };
    },

};
</script>