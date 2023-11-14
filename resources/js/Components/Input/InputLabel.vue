<script setup>
defineProps({
    value: {
        type: String,
    },
});
</script>

<template>
    <label class="block text-gray-500 dark:text-gray-300 font-bold md:text-right mb-1 md:mb-0 pr-4">
        <span v-if="value">{{ value }}</span>
        <span v-else><slot /></span>
    </label>
</template>
