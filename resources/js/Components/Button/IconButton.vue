<script setup lang="ts">

defineProps({
    solid: {
        type: Boolean,
        required: true,
    },
    iconName: {
        type: String,
        required: true,
    }
});
</script>

<template>
    <button class="btn btn-neutral p-2">
        <Component :is="iconName" class="w-4 h-4"/>
    </button>
</template>

<style scoped>

</style>
