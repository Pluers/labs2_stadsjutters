<template>
    <div>
        <h1>Edit User</h1>
        <form @submit.prevent="updateUser">
            <div>
                <img v-if="imageSrc" :src="imageSrc" width="50vw" alt="Selected image">
                <input id="image" type="file" accept="image/*" capture="environment" hidden @change="onImageChange">
                <button type="button" class="primary">
                    <label for="image">Choose Image</label>
                </button>
            </div>
            <div>
                <label for="first_name">First name:</label>
                <input id="first_name" v-model="user.first_name" type="text" required>
            </div>
            <div>
                <label for="last_name">Last name:</label>
                <input id="last_name" v-model="user.last_name" type="text" required>
            </div>
            <div>
                <label for="email">Email:</label>
                <input id="email" v-model="user.email" type="email" required>
            </div>
            <button class="primary" type="submit">Update</button>
        </form>
    </div>
</template>

<script>
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import axios from 'axios';

export default {
    setup() {
        const router = useRouter();
        const user = ref({
            image: null,
            first_name: '',
            last_name: '',
            email: '',
        });

        const getUser = async () => {
            try {
                const response = await axios.get('/api/user');
                user.value = response.data;
            } catch (error) {
                console.error('Failed to get user:', error);
            }
        };

        const updateUser = async () => {
            try {
                const formData = new FormData();
                formData.append('first_name', user.value.first_name);
                formData.append('last_name', user.value.last_name);
                formData.append('email', user.value.email);

                // If the user selected a new image, add it to the form data
                if (user.value.image instanceof File || user.value.image instanceof Blob) {
                    console.log('Appending image:', user.value.image); // Log the image file
                    formData.append('picture', user.value.image, user.value.image.name); // Add a filename
                } else {
                    console.log('No image to append:', user.value.image); // Log if no image file
                }

                // Add the _method field
                formData.append('_method', 'PUT');

                // Log the form data
                console.log([...formData]);

                // Get the CSRF token from the meta tag
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                // Send the form data to the server
                const response = await fetch('/api/user/update', {
                    method: 'POST', // Use 'POST' method because we're sending FormData
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: formData,
                });

                if (response.ok) {
                    const data = await response.json();
                    console.log(data);
                    router.push(`profile`);
                } else {
                    const errorData = await response.text(); // Get the response body as text
                    console.error('Server responded with an error:', errorData);
                    const message = `An error has occurred: ${response.status}`;
                    throw new Error(message);
                }
            } catch (error) {
                console.error('Failed to update user:', error);
            }
        };

        const imageName = ref(''); // Reactive property for the image name
        const imageSrc = ref(''); // Reactive property for the image source

        const onImageChange = (event) => {
            user.value.image = event.target.files[0];
            imageName.value = event.target.files[0].name; // Set the image name
            imageSrc.value = URL.createObjectURL(event.target.files[0]); // Create a URL representing the selected file
        };
        const chooseImage = () => {
            const imageInput = document.getElementById('image');
            imageInput.click();
        };

        onMounted(getUser);

        return {
            user,
            updateUser,
            chooseImage,
            onImageChange,
            imageName,
            imageSrc,
        };
    },
};
</script>