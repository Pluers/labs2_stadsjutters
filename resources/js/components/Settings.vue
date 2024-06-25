<template>
    <div id="settings">
        <section>
            <h2>Account</h2>
            <p>Delete account</p>
            <button class="secondary" v-on:click="logout">Logout</button>
        </section>
        <hr>
        <section>
            <h2>About</h2>
            <p><small>Version 0.9 alpha</small></p>
        </section>
    </div>

</template>

<script>
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