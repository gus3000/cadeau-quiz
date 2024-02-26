<script setup lang="ts">
import {ref} from "vue";
import {v4 as uuidv4} from 'uuid';

const props = defineProps({
    label: String,
    accept: String,
    preview: String | null,
});
defineEmits(['onChange']);
const input = ref(null);
const fileFormId = uuidv4();
</script>

<template>
    <div class="flex items-center justify-center w-full">
        <label :for="fileFormId"
               class="flex flex-row items-center justify-around w-3/4 h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
            <img v-if="preview" class="rounded-lg" :src="preview" alt="aperçu"/>
            <div class="flex flex-col items-center justify-center">
                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                    <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                         xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                    </svg>
                    <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Cliquer pour parcourir</span>
                        ou faire un glisser-déposer</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ label }}</p>
                </div>
                <input :id="fileFormId"
                       type="file"
                       class="hidden"
                       :accept="accept"
                       @input="$emit('onChange')"
                />
            </div>
        </label>
    </div>
</template>

<style scoped>
img {
    max-width: 200px;
    max-height: 200px;
}
</style>