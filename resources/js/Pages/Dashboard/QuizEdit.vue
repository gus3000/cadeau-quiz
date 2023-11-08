<script setup lang="ts">

import DashboardLayout from "@/Layouts/DashboardLayout.vue";
import {computed, ref, watch} from 'vue';
import type {TQuiz} from "@/Model/TQuiz";
import QuizQuestionEdit from "@/Components/Quiz/QuizQuestionEdit.vue";
import LabeledTextInput from "@/Components/LabeledTextInput.vue";
import axios from "axios";
import {debounce} from "@/Services/Debounce";
import type {TQuestion} from "@/Model/TQuestion";

const props = defineProps<{
  quiz: TQuiz,
  errors: TQuiz,
}>();

let isDirty = ref(false);

function submit() {
  axios.put(route("quizzes.update", props.quiz as any), props.quiz);
}

const debounceSubmit = debounce(function () {
  submit();
  isDirty.value = false;

}, 1000);

const orderedQuestions = computed(
    () => {
      return props.quiz.questions.sort((a, b) => a.order - b.order);
    }
);

watch(props.quiz, async () => {
  isDirty.value = true;
  console.log('watcher triggered');
  debounceSubmit();
});

const saveMessage = computed(() => {
  return isDirty.value ? 'saving...' : '';
})

function normalizeOrders() {
  for (let [i, question] of props.quiz.questions.entries()) {
    question.order = i + 1;
  }
}

function exchangeQuestions(order1: number, order2: number) {
  console.log("exchanging questions", order1, "and", order2);
  normalizeOrders();
  const nbQuestions = props.quiz.questions.length;
  if (order1 < 1 || order2 < 1 || order1 >= nbQuestions || order2 >= nbQuestions)
    return;
  let question1 = props.quiz.questions.filter((q) => q.order === order1)[0];
  let question2 = props.quiz.questions.filter((q) => q.order === order2)[0];
  console.log('questions :', question1, question2);
  question1.order = order2;
  question2.order = order1;
}

function moveUp(question: TQuestion): void {
  console.log("move up", question);
  exchangeQuestions(question.order, question.order - 1);
}

function moveDown(question: TQuestion): void {
  exchangeQuestions(question.order, question.order + 1);
}
</script>

<template>
  <DashboardLayout :title="quiz.name + saveMessage">
    <!--    <Text v-show="isDirty" class="text-center dark:text-gray-400">Sauvegarde en cours...</Text>-->
    <form
        class="divide-y divide-dashed divide-gray-700"
        @submit.prevent="submit"
    >
      <div>
        <LabeledTextInput
            v-model="quiz.name"
            name="quiz.name"
            :error="errors.name"
            label="Nom"
        />
      </div>
      <QuizQuestionEdit
          v-for="question in orderedQuestions"
          :question="question"
          @move-up="moveUp"
          @move-down="moveDown"
          :total-number-of-questions="quiz.questions.length"
      />

      <div></div>
    </form>
  </DashboardLayout>
</template>

<style scoped>

</style>
