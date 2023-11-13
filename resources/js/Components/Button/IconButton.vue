<script setup lang="ts">

defineProps({
    solid: {
        type: Boolean,
        required: true,
    },
    iconName: {
        type: Object,
        required: true,
    },
    disabled: {
        type: Boolean,
        default: false,
    }
});
</script>

<template>
    <button class="btn btn-neutral p-2" :disabled="disabled">
        <Component :is="iconName" class="w-4 h-4"/>
    </button>
</template>

<style scoped>

</style>
