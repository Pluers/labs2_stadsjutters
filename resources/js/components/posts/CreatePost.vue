<template>
    <div>
        <h1>Create Post</h1>
        <form @submit.prevent="createPost">
            <div>
                <img :src="imageSrc" width="50vw" alt="Selected image">
                <input id="image" type="file" accept="image/*" capture="environment" hidden @change="onImageChange">
                <button class="primary">
                    <label for="image">Choose Image</label>
                </button>
            </div>
            <div>
                <label for="name">Title:</label>
                <input id="name" type="text" required>
            </div>
            <div>
                <label for="name">Body:</label>
                <input id="name" type="text" required>
            </div>
            <div>
                <label for="name">Condition:</label>
                <input id="name" type="text" required>
            </div>
            <button class="primary" type="submit">Create</button>
        </form>
    </div>
</template>

<script>
import { ref, onMounted } from 'vue';

export default {
    setup() {
        const post = ref({
            image: null,
            title: '',
            body: '',
            tags: '',
            condition: '',
        });
        const imageName = ref(''); // Reactive property for the image name
        const imageSrc = ref(''); // Reactive property for the image source

        const onImageChange = (event) => {
            post.value.image = event.target.files[0];
            imageName.value = event.target.files[0].name; // Set the image name
            imageSrc.value = URL.createObjectURL(event.target.files[0]); // Create a URL representing the selected file
        };
        const chooseImage = () => {
            const imageInput = document.getElementById('image');
            imageInput.click();
        };

        const createPost = async () => {
            const formData = new FormData();
            formData.append('image', post.value.image);
            formData.append('title', post.value.title);
            formData.append('body', post.value.body);
            formData.append('condition', post.value.condition);

            const response = await fetch('/api/posts', { // replace '/api/posts' with your actual API endpoint
                method: 'POST',
                body: formData,
            });

            if (!response.ok) {
                const message = `An error has occurred: ${response.status}`;
                throw new Error(message);
            }

            const result = await response.json();
            console.log(result);
        };

        return {
            post,
            onImageChange,
            chooseImage,
            imageName,
            imageSrc,
            createPost, // add this line
        };
    },
};
</script>

<style scoped>
/* Your CSS here */
</style>