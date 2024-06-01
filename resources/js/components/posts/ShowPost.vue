<template>
    <div v-if="post" id="post">
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
        const post = ref(null);
        const router = useRouter();

        onMounted(() => {
            fetchPost(router.currentRoute.value.params.postid);
        });

        const fetchPost = async (id) => {
            const response = await fetch(`/post/get/${id}`);
            if (response.ok) {
                const text = await response.text(); // Get the raw response text
                console.log(text); // Log the raw response text
                try {
                    const data = JSON.parse(text); // Try to parse the response text as JSON
                    if (data) {
                        post.value = data;
                    }
                } catch (error) {
                    console.error('Failed to parse response as JSON:', error);
                }
            }
        };

        return {
            post,
            fetchPost
        };
    }
};
</script>