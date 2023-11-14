<script setup lang="ts">

defineProps({
    text: {
        type: String,
        required: true,
    },
});
</script>

<template>
    <button type="button" class="btn btn-neutral p-2 flex items-center gap-3" :disabled="disabled">
        <span>{{text}}</span>
    </button>
</template>

<style scoped>

</style>
