<script setup lang="ts">

import {Head} from "@inertiajs/vue3";
import DashboardLayout from "@/Layouts/DashboardLayout.vue";
import QuizRecap from "@/Components/Quiz/QuizRecap.vue";
import type {TQuiz} from "@/Model/TQuiz";

const props = defineProps<{
    quizzes: TQuiz[]
}>()
</script>

<template>
    <DashboardLayout title="Mes quiz">
        <div class="p-6 text-gray-900 dark:text-gray-100 gap-4">
            <div class="divide-y divide-gray-200 dark:divide-gray-700 flex flex-col items-center">
                <QuizRecap v-for="quiz in quizzes" :quiz="quiz" class="h-10 w-80"/>
            </div>
        </div>
    </DashboardLayout>
</template>

<style scoped>

</style>
