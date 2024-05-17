<template>
    <transition name="slide">
        <div ref="overlay" :style="{ left: 'calc(' + overlayPosition + '% - ' + overlayWidth/2 + 'px)' }" class="overlay"></div>
    </transition>
    <router-link to="/" @click.native="moveOverlay(16.66)">
        <span class="material-symbols-rounded" :class="{ selected: isNear(16.66) }">
            home
        </span>
        <p>Home</p>
    </router-link>
    <router-link to="/map" @click.native="moveOverlay(50)">
        <span class="material-symbols-rounded" :class="{ selected: isNear(50) }">
            map
        </span>
        <p>Map</p>
    </router-link>
    <router-link to="/profile" @click.native="moveOverlay(83.33)">
        <span class="material-symbols-rounded" :class="{ selected: isNear(83.33) }">
            person
        </span>
        <p>Profile</p>
    </router-link>
</template>

<script>
export default {
    data() {
        return {
            overlayPosition: 0,
            overlayWidth: 0
        }
    },
    methods: {
        moveOverlay(position) {
            this.overlayPosition = position;
            this.$nextTick(() => {
                const overlay = this.$refs.overlay;
                const style = window.getComputedStyle(overlay);
                this.overlayWidth = parseFloat(style.width);
            });
        },
        handleResize() {
            this.moveOverlay(this.overlayPosition);
        },
        isNear(target) {
            const range = 5;  // Change this to adjust the range
            return Math.abs(this.overlayPosition - target) <= range;
        }
    },
    mounted() {
        this.moveOverlay(16.66);  // Set initial position
        window.addEventListener('resize', this.handleResize);
    },
    beforeDestroy() {
        window.removeEventListener('resize', this.handleResize);
    }
}
</script>

<style scoped>
/* Your CSS here */

</style>