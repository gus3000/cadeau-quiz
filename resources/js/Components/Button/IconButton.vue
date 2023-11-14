<script setup lang="ts">

import Text from "@/Components/Text.vue";

defineProps({
    iconName: {
        type: Object,
        required: true,
    },

    text: {
        type: String,
        default: "",
    },
    solid: {
        type: Boolean,
        default: false,
    },
    disabled: {
        type: Boolean,
        default: false,
    }
});
</script>

<template>
    <button type="button" class="btn btn-neutral p-2 flex items-center gap-3" :disabled="disabled">
        <Component :is="iconName" :solid="solid" class="w-4 h-4 fill-white"/>
        <span v-if="text">{{text}}</span>
    </button>
</template>

<style scoped>

</style>
