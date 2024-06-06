<template>
    <div v-if="post === 'loading'">
        <h1>Loading...</h1>
    </div>
    <div v-else-if="post" id="post">
        <h1>Edit Post</h1>
        <form @submit.prevent="submitForm">
            <img v-if="imageSrc" :src="imageSrc" width="50vw" alt="Selected image">
            <input id="image" type="file" accept="image/*" capture="environment" hidden @change="onImageChange">
            <button type="button" class="primary">
                <label for="image">Choose Image</label>
            </button>

            <label for="title">Title:</label>
            <input id="title" v-model="post.title">

            <label for="body">Body:</label>
            <textarea id="body" v-model="post.body"></textarea>

            <div>
                <label for="condition">Condition:</label>
                <select id="condition" v-model="post.condition" required>
                    <option disabled value="">Please select one</option>
                    <option>New</option>
                    <option>Used</option>
                </select>
            </div>
            <div>
                <label for="location">Location:</label>
                <input id="location" type="text" v-model="post.location" :hidden="post.location" required>
                <p>{{ post.location }}</p>
                <button type="button" @click="getLocation">Get Location</button>
            </div>
            <button type="submit">Edit post</button>
        </form>
    </div>
    <div v-else>
        <h1>Post not found</h1>
    </div>
</template>

<script>
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import axios from 'axios';

const originalPost = ref(null); // Declare originalPost

export default {
    setup() {
        const post = ref('loading');
        const router = useRouter();
        const imageSrc = ref(null);
        const image = ref(null);


        onMounted(() => {
            fetchPost(router.currentRoute.value.params.postid);
        });

        const onImageChange = (event) => {
            if (event.target.files && event.target.files[0]) {
                image.value = event.target.files[0];
                imageSrc.value = URL.createObjectURL(event.target.files[0]);
            }
        };
        const chooseImage = () => {
            const imageInput = document.getElementById('image');
            imageInput.click();
        };

        const fetchPost = async (id) => {
            try {
                const response = await axios.get(`/api/post/get/${id}`);
                if (response.status === 200) {
                    post.value = response.data;
                    originalPost.value = { ...response.data }; // Set the initial value of originalPost
                    document.title = `Edit ${response.data.title}`;
                } else {
                    post.value = null;
                }
            } catch (error) {
                console.error('Failed to fetch post:', error);
                post.value = null;
            }
        };

        const submitForm = async () => {
            try {
                // Create a new FormData object
                const formData = new FormData();

                // Add the post data to the form data
                formData.append('title', post.value.title);
                formData.append('body', post.value.body);
                formData.append('condition', post.value.condition);
                formData.append('location', post.value.location);

                // If the user selected a new image, add it to the form data
                if (image.value instanceof File || image.value instanceof Blob) {
                    console.log('Appending image:', image.value); // Log the image file
                    formData.append('image', image.value, image.value.name); // Add a filename
                }

                // Add the _method field
                formData.append('_method', 'PUT');

                // Log the form data
                console.log([...formData]);

                // Send the form data to the server
                const response = await axios.post(`/api/post/update/${post.value.id}`, formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                });

                // Log the response
                console.log(response);

                if (response.status === 200) {
                    router.push(`/post/${post.value.id}`);
                } else {
                    console.error('Failed to update post:', response);
                }
            } catch (error) {
                console.error('Failed to update post:', error);
            }
        };

        return {
            post,
            fetchPost,
            image,
            onImageChange,
            chooseImage,
            imageSrc,
            submitForm
        };
    }
};
</script>