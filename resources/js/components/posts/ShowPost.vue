<template>
    <div v-if="post === 'loading'">
        <h1>Loading...</h1>
    </div>
    <div v-else-if="post" id="post">
        <h1>{{ post.title }}</h1>
        <p>{{ post.body }}</p>
        <p>{{ post.condition }}</p>
        <img :src="post.image" alt="image">
    </div>
    <div v-else>
        <h1>Post not found</h1>
    </div>
</template>

<script>
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';

export default {
    setup() {
        const post = ref('loading'); // Initialize post as 'loading'
        const router = useRouter();

        onMounted(() => {
            fetchPost(router.currentRoute.value.params.postid);
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

        return {
            post,
            fetchPost
        };
    }
};
</script>