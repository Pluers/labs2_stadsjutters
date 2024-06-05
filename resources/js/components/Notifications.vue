<template>
    <div id="notifications">
        <h1>Notifications</h1>
        <p>Welcome to the notifications page!</p>
        <div class="notifications" v-for="notification in notifications" :key="notification.id">
            <div class="notification">
                <img :src="notification.image" alt="">
                <div class="notification-content">
                    <h3>
                        <router-link :to="{ name: 'Post', params: { postid: notification.post_id } }">
                            {{ notification.title }}
                        </router-link>
                    </h3>
                    <p>{{ notification.body }} {{ notification.location }}</p>
                </div>

            </div>

        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            notifications: [],
        };
    },
    async created() {
        const response = await axios.get('/api/notifications');
        this.notifications = response.data;
        console.log(this.notifications);
    },
};
</script>