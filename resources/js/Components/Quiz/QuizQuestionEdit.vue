<script setup lang="ts">
import type {TQuestion} from "@/Model/TQuestion";
import LabeledTextInput from "@/Components/LabeledTextInput.vue";
import TextInput from "@/Components/TextInput.vue";
import Checkbox from "@/Components/Checkbox.vue";
import ColorcodedCheckbox from "@/Components/Toggle.vue";
import Toggle from "@/Components/Toggle.vue";
import type {TAnswer} from "@/Model/TAnswer";
import QuizAnswerEdit from "@/Components/Quiz/QuizAnswerEdit.vue";

const props = defineProps<{
  question: TQuestion
}>();

function incorrectAnswers(): TAnswer[] {
  return props.question.answers.filter((answer) => !answer.correct);
}

</script>

<template>
  <div>
    <div class="block text-gray-500 dark:text-gray-300 font-bold m-5 pr-4">Question {{ question.order }}</div>
    <LabeledTextInput label="Énoncé" v-model="question.text"/>
    <QuizAnswerEdit v-for="answer in [question.correct_answer, ...incorrectAnswers()]"
                    :answer="answer"
    />
  </div>
</template>

<style scoped>

</style>
