<script setup lang="ts">

import {onMounted} from "vue";
import {createCountdown} from "@/Snap/countdown";

onMounted(() => {
    createCountdown("countdownContainer");
})
</script>

<template>

<svg id="countdownContainer" width="800" height="800">
<!--    <path d="M 10 315-->
<!--           L 110 215-->
<!--           A 30 50 0 0 1 162.55 162.45-->
<!--           L 172.55 152.45-->
<!--           A 30 50 -45 0 1 215.1 109.9-->
<!--           L 315 10" stroke="black" fill="green" stroke-width="2" fill-opacity="0.5"/>-->
</svg>

</template>

<style scoped>

</style>