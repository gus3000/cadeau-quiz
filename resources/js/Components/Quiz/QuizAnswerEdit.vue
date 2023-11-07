<script setup lang="ts">

import type {TAnswer} from "@/Model/TAnswer";
import TextInput from "@/Components/TextInput.vue";
import LabeledTextInput from "@/Components/LabeledTextInput.vue";
import {computed} from "vue";
import FloatingLabeledTextInput from "@/Components/FloatingLabeledTextInput.vue";

const props = defineProps<{
  answer: TAnswer
}>();

const label = computed(() => {
  if(props.answer.correct)
    return 'Bonne réponse';
  return 'Mauvaise réponse';
});

const labelColor = computed(() => {
  if(props.answer.correct)
    return ['text-green-400', 'peer-placeholder-shown:text-green-400/75'];
  return ['text-red-400', 'peer-placeholder-shown:text-red-400/75'];
});
</script>

<template>

  <div class="md:flex items-center mt-4 mb-2 px-4 md:gap-5">
    <FloatingLabeledTextInput
        :label="label"
        :label-color="labelColor"
        v-model="answer.text"
        class="w-full"
    />

<!--    <LabeledTextInput :label="label" v-model="answer.text" />-->
  </div>
</template>

<style scoped>

</style>
