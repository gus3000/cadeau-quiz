<script setup lang="ts">

import LabelledInput from "@/Components/Input/LabeledInput.vue";

defineProps({
  label: {
    type: String,
    required: true,
  },
  error: String,
  modelValue: Number
});
</script>

<template>
    <LabelledInput
        :label="label"
        input-type="number"
        :error="error"
        :model-value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
    />
</template>

<style scoped>

</style>
