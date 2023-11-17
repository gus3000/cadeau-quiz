<script setup lang="ts">
import {PropType} from "vue";
import type {TQuestion} from "@/Model/TQuestion";
import type {TQuiz} from "@/Model/TQuiz";
import {CloseCircleIcon} from "flowbite-vue-icons";
import IconButton from "@/Components/Button/IconButton.vue";
import {router} from "@inertiajs/vue3";


function nextQuestion() {
    axios.post(`/api/quiz/next-question`);
}

function closeQuiz() {
    axios.get(route('api.quiz.close', props.quiz as any)).then(() => {
        router.reload();
    })
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
        <div v-if="quiz?.finished" class="flex flex-fill justify-center items-center py-4">
            <IconButton :icon-name="CloseCircleIcon" text="Fermer le quiz" @click="closeQuiz"/>
        </div>
    </div>
</template>

<style scoped>

</style>
