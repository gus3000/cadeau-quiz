<script lang="ts" setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head} from '@inertiajs/vue3';
import type {TQuiz} from "@/Model/TQuiz.d.ts";
import type {PropType} from "vue";
import QuizQuestion from "@/Components/QuizQuestion.vue";

defineProps({quiz: Object as PropType<TQuiz>})
</script>

<template>
    <Head title="Quiz"/>
    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">QUIZ TIME</div>
                    <QuizQuestion v-for="question in quiz.questions" :question="question"/>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
