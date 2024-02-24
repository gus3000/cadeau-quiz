<script setup lang="ts">

import {onMounted, ref} from "vue";
import {createScene} from "@/Services/BabylonUtils";

const bjsCanvas = ref<HTMLCanvasElement | null>(null);

onMounted(() => {
    if(bjsCanvas.value)
    {
        createScene(bjsCanvas.value);
    }
})
</script>

<template>
    <canvas ref="bjsCanvas" width="500" height="500" />
</template>

<style scoped>

</style>