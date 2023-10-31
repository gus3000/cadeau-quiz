<script setup lang="ts">
import type {PropType} from "vue/dist/vue";
import type {TQuestion} from "@/Model/TQuestion";
import type {TQuiz} from "@/Model/TQuiz";


function nextQuestion() {
    console.log("next");
    axios.post(`/api/quiz/next-question`);
}

defineProps({
    quiz: Object as PropType<TQuiz>,
    question: Object as PropType<TQuestion>,
    questionFinished: Boolean,
})
</script>

<template>
    <div class="flex flex-auto flex-grow py-10 justify-center gap-4">
        <button
            v-if="question === null"
            class="btn btn-neutral"
            @click="nextQuestion()"
        >
            Commencer le quiz
        </button>
<!--        <button-->
<!--            v-if="question && questionFinished"-->
<!--            class="btn btn-neutral"-->
<!--            @click="closeQuestion()"-->
<!--        >-->
<!--            Afficher la réponse-->
<!--        </button>-->
        <button
            v-if="question && questionFinished"
            class="btn btn-neutral"
            @click="nextQuestion()"
        >
            Question suivante
        </button>
    </div>
</template>

<style scoped>

</style>
