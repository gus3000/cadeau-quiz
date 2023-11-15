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

const props = defineProps({
    quiz: Object as PropType<TQuiz>,
    question: Object as PropType<TQuestion>,
    guess: Object as PropType<TGuess>,
    admin: Boolean,
});

function setQuestionEndTimer() {
    // const rem = remainingSeconds.value
    const rem = props.question?.time_remaining_with_grace_period;
    console.log("remaining :", rem);
    if (rem && rem > 0) {
        // console.log("setting timer to", rem)
        // const showStatsTimeout = setTimeout(function () {
        //     // router.reload({only: ['question']});
        // }, (rem + Durations.TIME_TO_WAIT_BEFORE_STATS) * 1000)
        // const hideClockTimeout = setTimeout(() => {
        //     console.log("question finished !");
        // }, rem * 1000)
    }
}

function closeQuiz() {
    axios.get(route('api.quiz.close', props.quiz as any)).then(() => {
        router.reload();
    })
}

const questionFinished = computed(() => {
    if (props.question === null || props.question === undefined)
        return false;
    console.log('question :', props.question);
    return props.question?.time_remaining_with_grace_period <= 0;
});

setQuestionEndTimer();

Echo.private('quiz.flow')
    .listen('NextQuestion', (e: any) => {
        console.log("NEXT QUESTION", e);
        // console.log("question id before :", props.question?.id);
        router.reload({
            only: ['quiz', 'question'], onFinish: () => {
                // console.log("question id after :", props.question.id);
                setQuestionEndTimer();
            }
        })
    })
    .listen('QuestionClosed', () => {
        console.log("Question closed !");
        router.reload({only: ['question', 'guess']});
    });
</script>

<template>
    <Head title="Quiz"/>
    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">{{ quiz?.name }} -
                        {{ quiz?.id }}
                    </div>
                    <div class="bg-white p-12 rounded-lg shadow-lg w-full mt-8">
                        <QuizQuestion
                            v-if="question"
                            :question="question"
                            :guess="guess"
                            :questionFinished="questionFinished"/>
                        <div v-if="quiz?.finished">
                            Quiz terminé !
                            Prochainement, des stats !
                            <div class="flex flex-fill justify-center items-center py-4">
                                <IconButton :icon-name="CloseCircleIcon" text="Fermer le quiz" @click="closeQuiz"/>
                            </div>
                        </div>
                        <QuizAdminPanel
                            v-if="!quiz?.finished && admin"
                            :quiz="quiz"
                            :question="question"
                            :question-finished="questionFinished"
                        />
                    </div>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script lang="ts">
</script>
