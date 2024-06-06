<template>
    <div>
        <h1>Create Post</h1>
        <form @submit.prevent="createPost">
            <div>
                <img v-if="imageSrc" :src="imageSrc" width="50vw" alt="Selected image">
                <input id="image" type="file" accept="image/*" capture="environment" hidden @change="onImageChange">
                <button type="button" class="primary">
                    <label for="image">Choose Image</label>
                </button>
            </div>
            <div>
                <label for="title">Title:</label>
                <input id="title" type="text" v-model="post.title" required>
            </div>
            <div>
                <label for="body">Body:</label>
                <input id="body" type="text" v-model="post.body" required>
            </div>
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
                <p>{{ post.address }}</p>
                <button type="button" @click="getLocation">Get Location</button>
            </div>
            <button class="primary" type="submit">Create</button>
        </form>
    </div>
</template>

<script>
import { ref } from 'vue';
import { useRouter } from 'vue-router';

export default {
    setup() {
        const post = ref({
            image: null,
            title: '',
            body: '',
            tags: '',
            condition: '',
            location: '',
        });
        const router = useRouter();
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
            formData.append('location', post.value.location);
            formData.append('address', post.value.address);

            for (var pair of formData.entries()) {
                console.log(pair[0] + ', ' + pair[1]);
            }
            // Get the CSRF token from the meta tag
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            const response = await fetch('/api/post/store', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: formData,
            });

            if (response.ok) {
                const data = await response.json();
                console.log(data);
                router.push(`/post/${data.post_id}`);
            } else {
                const message = `An error has occurred: ${response.status}`;
                throw new Error(message);
            }
        };

        return {
            post,
            onImageChange,
            chooseImage,
            imageName,
            imageSrc,
            createPost,
        };
    },
    methods: {
        async getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(async (position) => {
                    const response = await fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${position.coords.latitude}&lon=${position.coords.longitude}`);
                    const data = await response.json();
                    const address = data.address;
                    this.post.location = `Latitude: ${position.coords.latitude}, Longitude: ${position.coords.longitude}`;
                    this.post.address = `${address.road}${address.house_number ? ' ' + address.house_number : ''}   ${address.postcode}, ${address.suburb ? address.suburb : address.city}, ${address.state}`;
                });
            } else {
                alert("Geolocation is not supported by this browser.");
            }
        },
    },
};
</script>