<script setup lang="ts">


import TextInput from "@/Components/Input/TextInput.vue";
import {computed, PropType} from "vue";
import {v4 as uuidv4} from 'uuid'

const props = defineProps({
    label: {
        type: String,
        required: true,
    },
    labelColor: {
        type: Array as PropType<string[]>,
        default: ['text-gray-400', 'peer-placeholder-shown:text-gray-300'],
    },
    error: String,
    modelValue: String
});

const labelTextClass = computed(() => {
    if (!props.labelColor)
        return 'text'
})

const uuid = uuidv4();
</script>

<template>
    <div class="relative">
        <TextInput
            type="text"
            :id="uuid"
            :model-value="modelValue"
            @input="$emit('update:modelValue', $event.target.value)"
            class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
            placeholder=" "
        />
        <label
            :for="uuid"
            class="absolute text-sm duration-300 transform -translate-y-4 rounded-lg scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 dark:peer-focus:bg-blue-950 px-2 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1"
            :class="labelColor"
        >{{ label }}</label>
    </div>
</template>

<style scoped>

</style>
