<script setup lang="ts">

import InputLabel from "@/Components/Input/InputLabel.vue";
import UserSearchInput from "@/Components/Input/UserSearch/UserSearchInput.vue";

defineProps({
    label: {
        type: String,
        required: true,
    },
    quiz: {
        required: true,
    },
    inputType: String,
    error: String,
    modelValue: {
        type: [String, Number],
    }
});
</script>

<template>
    <div class="text-center">
        <div class="md:flex md:items-center mt-4 mb-2 px-4">
            <div class="md:w-1/4">
                <InputLabel :for="modelValue" :value="label"/>
            </div>
            <div class="md:w-3/4">
                <UserSearchInput
                    :quiz="quiz"/>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>