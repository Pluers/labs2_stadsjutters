<template>
    <div id="profile" v-if="post === 'notFound'">
        <h1>Post not found</h1>
        <router-link :to="{ name: 'Home' }">
            <button class="secondary">
                Back Home
            </button>
        </router-link>
    </div>
    <div v-else-if="post === 'loading'">
        <h1>Loading...</h1>
    </div>
    <div v-else-if="post" id="post">
        <img :src="post.image" alt="image">
        <h1>{{ post.title }}</h1>
        <button class="primary" v-if="user && post.user_id === user.id" @click="editPost">Edit Post</button>
        <hr>
        <h2>Information</h2>
        <router-link class="userLink" :to="{ name: 'UserProfile', params: { userid: post.user.id } }">
            <span class="material-symbols-rounded post-icons">
                person
            </span>
            <p>
                {{ post.user.first_name }} {{ post.user.last_name }}
            </p>
        </router-link>
        <p>Description: {{ post.body }}</p>
        <p>Condition: {{ post.condition }}</p>
        <p>Dimensions: {{ post.dimensions }}</p>
        <p>Available Until: {{ post.available_until ? post.available_until : "No end date" }}</p>
        <h2>Location</h2>
        <p>Coordinates: <br>{{ post.location }}</p>
        <p>Address: <br>{{ post.address.road }} {{ post.address.house_number ? post.address.house_number : '' }}
            {{ post.address.postcode }},
            {{ post.address.suburb ? post.address.suburb : city }}, {{ post.address.state }}
        </p>


    </div>
</template>

<script>
import { ref, onMounted, computed } from 'vue';
import { useRouter } from 'vue-router';
import axios from 'axios';

export default {
    setup() {
        const post = ref('loading'); // Initialize post as 'loading'
        const router = useRouter();
        const user = ref(null);
        const id = computed(() => router.currentRoute.value.params.postid)

        const getUser = async () => {
            try {
                // try a request to the server to get the user information only when the user is logged in and validated
                const response = await axios.get('/api/user');
                user.value = response.data;
            } catch (error) {
                console.error('Failed to get user:', error);
            }
        };

        const fetchPost = async (id) => {
            try {
                const response = await axios.get(`/api/post/get/${id}`);
                if (response.status === 200) {
                    const postData = response.data;
                    const userResponse = await axios.get(`/api/user/${postData.user_id}`);
                    if (userResponse.status === 200) {
                        postData.user = userResponse.data;
                    }
                    // Parse the location string to extract the latitude and longitude
                    const location = postData.location.split(', ');
                    const lat = parseFloat(location[0].split(': ')[1]).toFixed(3);
                    const lng = parseFloat(location[1].split(': ')[1]).toFixed(3);
                    // Make a request to the Nominatim API
                    const nominatimResponse = await axios.get(`https://nominatim.openstreetmap.org/reverse?format=json&addressdetails=1&lat=${lat}&lon=${lng}`);
                    if (nominatimResponse.status === 200) {
                        // Store the address data in the post object
                        postData.address = nominatimResponse.data.address;
                        console.log(postData.address);
                    }
                    if (postData) {
                        post.value = postData; // now correctly refers to the ref
                        document.title = postData.title;
                    }
                } else {
                    post.value = 'notFound';
                }
            } catch (error) {
                console.error('Failed to fetch post:', error);
                post.value = 'notFound';
            }
        };

        const editPost = () => {
            // Redirect to the edit post page
            router.push(`/post/edit/${post.value.id}`);
        };

        onMounted(async () => {
            await getUser();
            await fetchPost(id.value);
            console.log(post, id);
        });

        return {
            post,
            user,
            fetchPost,
            editPost
        };
    }
};
</script>