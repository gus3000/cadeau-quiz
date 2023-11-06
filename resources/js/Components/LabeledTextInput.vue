<script setup lang="ts">


import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";

defineProps({
  label: {
    type: String,
    required: true,
  },
  error: String,
  modelValue: String
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
            type="text"
            class="mt-1 block w-full"
            :model-value="modelValue"
            @input="$emit('update:modelValue', $event.target.value)"
            required
            autofocus
            autocomplete="name"
        />
      </div>
    </div>
    <InputError :message="error"/>
  </div>
</template>

<style scoped>

</style>
