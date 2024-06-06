<template>
    <div id="map">
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            map: null,
            markers: [],
            posts: [],
        };
    },
    async created() {
        try {
            const response = await axios.get('/api/post/getall');
            this.posts = response.data.map(post => {
                const location = post.location.match(/Latitude: (\S+), Longitude: (\S+)/);
                const parsedLocation = {
                    lat: parseFloat(location[1]).toFixed(3),
                    lng: parseFloat(location[2]).toFixed(3),
                    id: post.id,
                    title: post.title,
                    image: post.image,
                    user_id: post.user_id,
                    user_first_name: post.user.first_name,
                    user_last_name: post.user.last_name,
                    user_email: post.user.email,
                };
                return parsedLocation;
            });
            this.initMap();
            this.addMarkers();
        } catch (error) {
            console.error(error);
        }
    },
    methods: {
        initMap() {
            this.map = L.map('map').setView([52.1326, 5.2913], 9); // Change the latitude and longitude
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
            }).addTo(this.map);
        },
        addMarkers() {
            this.posts.forEach(post => {
                const marker = L.marker([post.lat, post.lng]).addTo(this.map);
                marker.bindPopup("Fetching post information...");
                this.markers.push(marker);

                marker.on('click', async () => {
                    const response = await axios.get(`https://nominatim.openstreetmap.org/reverse?format=json&addressdetails=1&lat=${parseFloat(post.lat).toFixed(3)}&lon=${parseFloat(post.lng).toFixed(3)}`);
                    const address = response.data.address;
                    console.log(address);
                    marker.setPopupContent(`
                <a href="/post/${post.id}">
                    <img class="post-image popup-image" src="${post.image}" alt="" />
                    <h2>${post.title}</h2>
                    <a class="userLink" href="/profile/${post.user_id}">
                        <span class="material-symbols-rounded post-icons">
                            person
                        </span>
                        <p>
                            ${post.user_first_name} ${post.user_last_name}
                        </p>
                    </a>
                    <p>
                        <span class="material-symbols-rounded post-icons">
                            location_on
                        </span>
                    ${address.road}${address.house_number ? ' ' + address.house_number : ''}, ${address.suburb ? address.suburb : address.city}
                    </p>
                </a>`);
                });
            });
        },
    },
};
</script>