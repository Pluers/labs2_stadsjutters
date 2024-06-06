<template>
    <router-link :to="{ name: 'Post', params: { postid: post.id } }" class="post">
        <img class="post-image" :src="post.image" alt="" />
        <div class="post-content">
            <div class="post-header">
                <h1 class="post-title"><b>{{ post.title }}</b></h1>
                <p class="post-title">{{ post.tags }}</p>
            </div>
            <div class="post-body">
                <div class="post-content-row">
                    <span class="material-symbols-rounded post-icons">
                        location_on
                    </span>
                    <p v-if="this.localPost.address == ''">Fetching address...</p>
                    <p v-else>{{ this.localPost.address }}</p>
                </div>
                <div class="post-content-row">
                    <span class="material-symbols-rounded post-icons">
                        person
                    </span>
                    <p>{{ post.user ? `${post.user.first_name} ${post.user.last_name}` : 'User not found' }}</p>
                </div>
                <div class="post-content-row">
                    <span class="material-symbols-rounded post-icons">
                        calendar_add_on
                    </span>
                    <p>
                        {{
                            new Date(post.created_at).getDate() + ' ' +
                            new Date(post.created_at).toLocaleString(undefined, { month: 'short' }) + ' ' +
                            new Date(post.created_at).toLocaleTimeString(undefined, { hour: '2-digit', minute: '2-digit', hour12: false })
                        }}
                    </p>
                </div>
                <div class="post-content-row" v-if="post.available_until">
                    <span class="material-symbols-rounded post-icons">
                        calendar_clock
                    </span>
                    <p>{{ new Date(post.available_until).toLocaleDateString() }}</p>
                </div>


            </div>
        </div>
    </router-link>
</template>

<script>
import axios from 'axios';
export default {
    props: {
        post: {
            type: Object,
            required: true
        }
    },
    data() {
        return {
            localPost: {
                location: null,
                address: ''
            }
        };
    },
    methods: {
        async getAddress() {
            if (this.post && this.post.location) {
                const latMatch = this.post.location.match(/Latitude: (\d+\.\d{3})/);
                const lngMatch = this.post.location.match(/Longitude: (\d+\.\d{3})/);
                if (latMatch && lngMatch) {
                    const lat = latMatch[1];
                    const lng = lngMatch[1];
                    const response = await axios.get(`https://nominatim.openstreetmap.org/reverse?format=json&addressdetails=1&lat=${lat}&lon=${lng}`);
                    const address = response.data.address;
                    console.log(address);
                    this.localPost.address = `${address.road}${address.house_number ? ' ' + address.house_number : ''}, ${address.city}`;
                }
            }
        }
    },
    created() {
        this.getAddress();
    }
}
</script>