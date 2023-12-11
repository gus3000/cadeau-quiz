<script setup lang="ts">

import DefaultTwitchExtension from "@/Pages/TwitchExtension/DefaultTwitchExtension.vue";
import {computed, PropType} from "vue";
import {User} from "@/Types";
import QuizComponent from "@/Components/Quiz/QuizComponent.vue";
import {TQuiz} from "@/Model/TQuiz";
import type {TQuestion} from "@/Model/TQuestion";
import {TGuess} from "@/Model/TGuess";
import {TStats} from "@/Model/TStats";

const props = defineProps({
    user: Object as PropType<User>,
    quiz: Object as PropType<TQuiz>,
    question: Object as PropType<TQuestion>,
    guess: Object as PropType<TGuess>,
    questionStats: Object as PropType<TStats>,
    quizStats: Object as PropType<TStats>,
});

const questionFinished = computed(() => {
    if (props.question === null || props.question === undefined)
        return false;
    // console.log('question :', props.question);
    return props.question?.time_remaining_with_grace_period <= 0;
});
</script>

<template>
    <div class="min-h-screen flex justify-center items-end">
        <!--        <div>-->
        <!--            <div>Debug fullscreen : </div>-->
        <!--            <pre>user : {{user}}</pre>-->
        <!--            <pre>quiz : {{quiz}}</pre>-->
        <!--            <pre>question : {{question}}</pre>-->
        <!--            <pre>guess : {{guess}}</pre>-->
        <!--        </div>-->
        <DefaultTwitchExtension/>
        <QuizComponent
            v-if="quiz"
            v-bind="{quiz,question,guess,questionStats,quizStats,questionFinished}"
            :overlay="true"
        />

    </div>

</template>

<style scoped>
pre {
    color: white;
}
</style>
