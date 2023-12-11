<script lang="ts" setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, router} from '@inertiajs/vue3';
import type {TQuiz} from "@/Model/TQuiz.d.ts";
import {computed, type PropType} from "vue";
import QuizQuestion from "@/Components/Quiz/QuizQuestion.vue";
import type {TQuestion} from "@/Model/TQuestion";
import QuizAdminPanel from "@/Components/Quiz/QuizAdminPanel.vue";
import {TGuess} from "@/Model/TGuess";
import IconButton from "@/Components/Button/IconButton.vue";
import {CloseCircleIcon} from "flowbite-vue-icons";
import QuizComponent from "@/Components/Quiz/QuizComponent.vue";
import {TStats} from "@/Model/TStats";

const props = defineProps({
    quiz: Object as PropType<TQuiz>,
    question: Object as PropType<TQuestion>,
    guess: Object as PropType<TGuess>,
    questionStats: Object as PropType<TStats>,
    quizStats: Object as PropType<TStats>,
    admin: Boolean,
});

// function setQuestionEndTimer() {
    // const rem = remainingSeconds.value
    // const rem = props.question?.time_remaining_with_grace_period;
    // console.log("remaining :", rem);
    // if (rem && rem > 0) {
        // console.log("setting timer to", rem)
        // const showStatsTimeout = setTimeout(function () {
        //     // router.reload({only: ['question']});
        // }, (rem + Durations.TIME_TO_WAIT_BEFORE_STATS) * 1000)
        // const hideClockTimeout = setTimeout(() => {
        //     console.log("question finished !");
        // }, rem * 1000)
    // }
// }

const questionFinished = computed(() => {
    if (props.question === null || props.question === undefined)
        return false;
    // console.log('question :', props.question);
    return props.question?.time_remaining_with_grace_period <= 0;
});

// setQuestionEndTimer();


</script>

<template>
    <Head title="Quiz"/>
    <AuthenticatedLayout>
        <QuizComponent
            v-bind="{quiz,question,guess,questionStats,quizStats,questionFinished}"
            />
        <QuizAdminPanel
            v-if="!quiz?.finished && admin"
            :quiz="quiz"
            :question="question"
            :question-finished="questionFinished"
        />
    </AuthenticatedLayout>
</template>

<script lang="ts">
</script>
