<script lang="ts" setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, router} from '@inertiajs/vue3';
import type {TQuiz} from "@/Model/TQuiz.d.ts";
import {computed, type PropType} from "vue";
import QuizQuestion from "@/Components/Quiz/QuizQuestion.vue";
import type {TQuestion} from "@/Model/TQuestion";
import QuizAdminPanel from "@/Components/Quiz/QuizAdminPanel.vue";
import {DateTime} from "luxon";
import {Durations} from "@/Constants";

const props = defineProps({
    quiz: Object as PropType<TQuiz>,
    question: Object as PropType<TQuestion>,
    admin: Boolean,
});

function setQuestionEndTimer() {
    const rem = remainingSeconds.value
    if (rem && rem > 0) {
        // console.log("setting timer to", rem)
        const showStatsTimeout = setTimeout(function () {
            router.reload({only: ['question']});
        }, (rem + Durations.TIME_TO_WAIT_BEFORE_STATS) * 1000)
        const hideClockTimeout = setTimeout(() => {
            console.log("question finished !");
            router.reload({only: ['question']});
        }, rem * 1000)
    }
}

const remainingSeconds = computed(() => {
    if (props.question === null)
        return null;
    if (props.question.opened_at === null)
        return null;
    let questionOpenDate = DateTime.fromISO(props.question.opened_at, {zone: "UTC"});
    let questionCloseDate = questionOpenDate.plus({seconds: props.question.duration});
    let now = DateTime.now();
    // console.log("raw opened date :", props.question.opened_at)
    // console.log("question opened at ", questionOpenDate.toString());
    // console.log("question closes at ", questionCloseDate.toString());
    // console.log("current date :", now.toString())

    let remaining = questionCloseDate.diff(now).as('seconds');
    return Math.max(remaining, 0);

});

const questionFinished = computed(() => {
    return remainingSeconds.value <= 0;
});

setQuestionEndTimer();

Echo.private('quiz.flow')
    .listen('NextQuestion', (e) => {
        console.log("NEXT QUESTION", e);
        // console.log("question id before :", props.question?.id);
        router.reload({
            only: ['question'], onFinish: () => {
                // console.log("question id after :", props.question.id);
                setQuestionEndTimer();
            }
        })

    })
</script>

<template>
    <Head title="Quiz"/>
    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">{{ quiz.name }} -
                        {{ quiz.id }}{{ admin ? ' - admin' : '' }}
                    </div>
                    <div class="bg-white p-12 rounded-lg shadow-lg w-full mt-8">
<!--                        <pre>Remaining seconds : {{ remainingSeconds }}</pre>-->
<!--                        <pre>question finished : {{ questionFinished }}</pre>-->
                        <QuizQuestion :question="question"
                                      :remainingSeconds="remainingSeconds"
                                      :questionFinished="questionFinished"/>
                        <QuizAdminPanel
                            v-if="admin"
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
