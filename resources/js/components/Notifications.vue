<template>
    <div id="notifications">
        <h1>Notifications</h1>
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
                    <button @click="deleteNotification(notification.id)">Delete</button>
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
        await this.fetchNotifications();
    },
    methods: {
        async fetchNotifications() {
            const response = await axios.get('/api/notifications');
            this.notifications = response.data;
            return this.notifications;
        },
        async deleteNotification(id) {
            await axios.delete(`/api/notifications/delete/${id}`);
            const notifications = await this.fetchNotifications();
            if (notifications.length < 1) {
                location.reload();
            } else {
                fetchNotifications();
            }
        },
    },
};
</script>