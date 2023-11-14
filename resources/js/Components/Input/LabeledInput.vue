<script setup lang="ts">


import InputLabel from "@/Components/Input/InputLabel.vue";
import TextInput from "@/Components/Input/TextInput.vue";
import InputError from "@/Components/Input/InputError.vue";

defineProps({
    label: {
        type: String,
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
                <TextInput
                    :id="modelValue"
                    :type="inputType"
                    class="mt-1 block w-full"
                    :model-value="modelValue"
                    @input="$emit('update:modelValue', $event.target.value)"
                />
            </div>
        </div>
        <InputError :message="error"/>
    </div>
</template>

<style scoped>

</style>
