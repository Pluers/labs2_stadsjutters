<template>
    <!-- The element that highlights the selected page on the navbar -->
    <transition name="fade" mode="out-in">
        <div v-if="isNavbarRoute" ref="overlay" :style="overlayStyle" class="overlay"></div>
    </transition>
    <!-- 
        The router-link elements are used to navigate between pages
        The span elements are used to display the icons
        The p elements are used to display the names of the pages
        All are retrieved from the list below in the scripts element called routes
    -->
    <router-link v-for="(route, index) in routes" :key="index" :to="route.path"
        @click.native="moveOverlay(route.position)">
        <span class="material-symbols-rounded" :class="{ selected: isNear(route.position) && isNavbarRoute }">
            {{ route.icon }}
        </span>
        <p>{{ route.name.charAt(0).toUpperCase() + route.name.slice(1) }}</p>
    </router-link>
</template>

<script>
export default {
    data() {
        return {
            overlayPosition: 0,
            overlayWidth: 0,
            currentRoute: this.$route.path,
            // The available routes in the navbar
            routes: [
                { path: '/', name: 'home', icon: 'home', position: 16.66 },
                { path: '/map', name: 'map', icon: 'map', position: 50 },
                { path: '/profile', name: 'profile', icon: 'person', position: 83.33 }
            ]
        }
    },
    computed: {
        isNavbarRoute() {
            return this.routes.map(route => route.path).includes(this.currentRoute);
        },
        overlayStyle() {
            return { left: `calc(${this.overlayPosition}% - ${this.overlayWidth / 2}px)` };
        }
    },
    methods: {
        moveOverlay(position) {
            this.overlayPosition = position;
            this.$nextTick(this.updateOverlayWidth);
        },
        updateOverlayWidth() {
            const overlay = this.$refs.overlay;
            const style = window.getComputedStyle(overlay);
            this.overlayWidth = parseFloat(style.width);
        },
        handleResize() {
            this.moveOverlay(this.overlayPosition);
        },
        isNear(target) {
            const range = 10;
            return Math.abs(this.overlayPosition - target) <= range;
        }
    },
    watch: {
        '$route'(to, from) {
            this.currentRoute = to.path;
            const currentRoute = this.routes.find(route => route.path === this.currentRoute);
            const newPosition = currentRoute ? currentRoute.position : 16.66;
            this.moveOverlay(newPosition);
        }
    },
    mounted() {
        window.addEventListener('resize', this.handleResize);
    },
    beforeDestroy() {
        window.removeEventListener('resize', this.handleResize);
    }
}
</script>