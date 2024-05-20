<template>
    <div>
        <h1>Create Post</h1>
        <form @submit.prevent="createPost">
            <div>
                <img :src="imageSrc" alt="Selected image">
                <input id="image" type="file" accept="image/*" capture="environment" hidden @change="onImageChange">
                <button class="primary">
                    <label for="image">Choose Image</label>
                </button>
            </div>
            <div>
                <label for="name">Name:</label>
                <input id="name" type="text" required>
            </div>
            <!-- Add more fields as needed -->
            <button class="primary" type="submit">Update</button>
        </form>
    </div>
</template>

<script>
import { ref, onMounted } from 'vue';

export default {
    setup() {
        const post = ref({
            name: '',
            email: '',
            image: null,
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

        // Rest of your setup function

        return {
            post,
            onImageChange,
            chooseImage,
            imageName, // Return the image name
            imageSrc, // Return the image source
        };
    },
};
</script>

<style scoped>
/* Your CSS here */
</style>