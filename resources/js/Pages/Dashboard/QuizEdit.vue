<script setup lang="ts">

import DashboardLayout from "@/Layouts/DashboardLayout.vue";
import {router} from '@inertiajs/vue3'
import type {TQuiz} from "@/Model/TQuiz";
import QuizQuestionEdit from "@/Components/Quiz/QuizQuestionEdit.vue";

const props = defineProps<{
    quiz: TQuiz
}>();

function submit() {
    router.post("/quizzes", props.quiz);
}
</script>

<template>
    <DashboardLayout :title="quiz.name">
        <form @submit.prevent="submit">
            <input type="text" v-model="quiz.name">
            <div><button class="btn btn-neutral" type="submit">Submit</button></div>
        </form>
        <!--        <QuizQuestionEdit v-for="question in quiz.questions" :question="question"/>-->
    </DashboardLayout>
</template>

<style scoped>

</style>
