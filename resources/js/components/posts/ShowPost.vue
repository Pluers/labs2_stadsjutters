<template>
    <div v-if="post === 'loading'">
        <h1>Loading...</h1>
    </div>
    <div v-else-if="post" id="post">
        <h1>{{ post.title }}</h1>
        <p>{{ post.body }}</p>
        <p>{{ post.condition }}</p>
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

        // Get user information
        const getUser = async () => {
            try {
                // try a request to the server to get the user information only when the user is logged in and validated
                const response = await axios.get('/user');
                user.value = response.data;
                console.log(user.value);
            } catch (error) {
                console.error('Failed to get user:', error);
            }
        };

        onMounted(() => {
            fetchPost(router.currentRoute.value.params.postid);
            getUser();
        });

        const fetchPost = async (id) => {
            try {
                const response = await fetch(`/post/get/${id}`);
                if (response.ok) {
                    const text = await response.text();
                    console.log(text); // Log the raw response text
                    try {
                        const data = JSON.parse(text);
                        if (data) {
                            post.value = data;
                            document.title = data.title;
                        }
                    } catch (error) {
                        console.error('Failed to parse response as JSON:', error);
                    }
                } else {
                    // Set post to null if the response was not OK
                    // is needed to display the 'Post not found' message
                    post.value = null;
                }
            } catch (error) {
                // Set post to null if the fetch failed
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