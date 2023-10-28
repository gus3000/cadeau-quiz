<script lang="ts" setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, router} from '@inertiajs/vue3';
import type {TQuiz} from "@/Model/TQuiz.d.ts";
import type {PropType} from "vue";
import QuizQuestion from "@/Components/QuizQuestion.vue";
import type {TQuestion} from "@/Model/TQuestion";

Echo.private('quiz.2') //FIXME
    .listen('NextQuestion', (e) => {
        console.log("NEXT QUESTION", e);
        router.reload({only: ['question']})
    })

defineProps({
    quiz: Object as PropType<TQuiz>,
    question: Object as PropType<TQuestion>,
})
</script>

<template>
    <Head title="Quiz"/>
    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">QUIZ TIME</div>
                    <QuizQuestion :question="question"/>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script lang="ts">
</script>
