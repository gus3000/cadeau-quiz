<script setup lang="ts">

import DashboardLayout from "@/Layouts/DashboardLayout.vue";
import {router, Link} from '@inertiajs/vue3'
import type {TQuiz} from "@/Model/TQuiz";

const props = defineProps<{
    quiz: TQuiz
}>();
</script>

<template>
    <DashboardLayout :title="quiz.name">
        <Link :href="route('quizzes.edit', quiz as any)" class="btn btn-neutral">Modifier</Link>
<!--                <QuizQuestionView v-for="question in quiz.questions" :question="question"/>-->
    </DashboardLayout>
</template>

<style scoped>

</style>
