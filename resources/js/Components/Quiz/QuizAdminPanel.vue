<script setup lang="ts">
import type {PropType} from "vue/dist/vue";
import type {TQuestion} from "@/Model/TQuestion";
import type {TQuiz} from "@/Model/TQuiz";

function closeQuestion() {
    console.log("close");
    axios.post(`/api/quiz/close-question`);
}

function nextQuestion(quiz: TQuiz) {
    console.log("next");
    axios.post(`/api/quiz/next-question`);
}

defineProps({
    quiz: Object as PropType<TQuiz>,
    question: Object as PropType<TQuestion>,
})
</script>

<template>
    <div class="bg-white p-12 rounded-lg shadow-lg w-full mt-8">
        <div class="flex flex-auto flex-grow justify-center gap-4">
            <button
                v-if="question === null"
                class="btn btn-neutral"
                @click="nextQuestion()"
            >
                Commencer le quiz
            </button>
            <button
                v-if="question && question.open && !question.finished"
                class="btn btn-neutral"
                @click="closeQuestion()"
            >
                Afficher la réponse
            </button>
            <button
                v-if="question && !question.open && question.finished"
                class="btn btn-neutral"
                @click="nextQuestion()"
            >
                Question suivante
            </button>
        </div>
    </div>
</template>

<style scoped>

</style>
