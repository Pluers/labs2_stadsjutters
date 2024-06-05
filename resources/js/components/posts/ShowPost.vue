<template>
    <div v-if="post === 'loading'">
        <h1>Loading...</h1>
    </div>
    <div v-else-if="post" id="post">
        <h1>{{ post.title }}</h1>
        <p>{{ post.body }}</p>
        <p>{{ post.condition }}</p>
        <router-link :to="{ name: 'UserProfile', params: { userid: post.user.id } }">
            {{ post.user.first_name }} {{ post.user.last_name }}
        </router-link>
        <img :src="post.image" alt="image">
        <button v-if="user && post.user_id === user.id" @click="editPost">Edit Post</button>
    </div>
    <div v-else>
        <h1>Post not found</h1>
    </div>
</template>

<script>
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import axios from 'axios';

export default {
    setup() {
        const post = ref('loading'); // Initialize post as 'loading'
        const router = useRouter();
        const user = ref(null);

        onMounted(() => {
            fetchPost(router.currentRoute.value.params.postid);
            getUser();
        });

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
                    if (postData) {
                        post.value = postData; // now correctly refers to the ref
                        document.title = postData.title;
                    }
                } else {
                    post.value = null;
                }
            } catch (error) {
                console.error('Failed to fetch post:', error);
                post.value = null;
            }
        };
        const editPost = () => {
            // Redirect to the edit post page
            router.push(`/post/edit/${post.value.id}`);
        };

        return {
            post,
            user,
            fetchPost,
            editPost
        };
    }
};
</script>