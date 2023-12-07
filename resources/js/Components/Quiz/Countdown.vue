<script setup lang="ts">

import {computed, onBeforeUnmount, onMounted, type PropType, ref, watch} from "vue";
import {DateTime} from "luxon";
import $ from "jquery";

import type {TQuestion} from "@/Model/TQuestion";
import {restartAnimation} from "@/Services/Animation";


const SCORE_UPDATE_INTERVAL = 50;
const CLOCK_START_DELAY = 1000;

const emit = defineEmits(['updateScore']);

const props = defineProps<{
    question: TQuestion,
}>();

const maxScore = computed(() => props.question.time_remaining_with_grace_period * 1000);
const questionAlreadyStarted = computed(() => {
    return props.question.time_remaining_with_grace_period < props.question.duration
});
const clockStartDelay = computed(() => questionAlreadyStarted.value ? 0 : CLOCK_START_DELAY);

const score = ref<number>(props.question.time_remaining_with_grace_period * 1000);
const dynamicRemaining = ref<number>(props.question.time_remaining_with_grace_period);

let scoreTickInterval: number;
let lastTextRefresh = DateTime.now();

function tickScore() {
    let now = DateTime.now();
    let diff = now.diff(lastTextRefresh).as('seconds');
    lastTextRefresh = now;


    setScore(score.value - diff * 1000);
    // score.value -= diff * 1000;
    // score.value = Math.max(score.value, 0);

    dynamicRemaining.value -= diff;
    dynamicRemaining.value = Math.max(dynamicRemaining.value, 0);

    emit('updateScore', score.value);
    if (score.value <= 0) {
        score.value = 0;
        clearInterval(scoreTickInterval);
        scoreTickInterval = -1;
    }
}

function setScore(s:number) {
    if(s < 0)
        s = 0;
    else if(s > maxScore.value)
        s = maxScore.value;
    s = Math.round(s);
    score.value = s;
}

function initIntervals() {
    console.log("countdown restart !");
    let clockHand = document.getElementById('clock-hand');
    if (clockHand === null)
        return;

    restartAnimation(clockHand, 'rotating', clockStartDelay.value);

    dynamicRemaining.value = props.question.time_remaining_with_grace_period;
    score.value = props.question?.time_remaining_with_grace_period * 1000;
    if (scoreTickInterval) {
        clearInterval(scoreTickInterval);
    }
    setTimeout(() => {
        lastTextRefresh = DateTime.now();
        scoreTickInterval = setInterval(tickScore, SCORE_UPDATE_INTERVAL);
    }, clockStartDelay.value);
}


const clockDurationSeconds = computed(() => {
    return `${props.question.duration}s`;
});

const clockDelay = computed(() => {
    return `-${props.question.duration - props.question.time_remaining_with_grace_period}s`;
});

// let lastTextRefresh = DateTime.now();
// const textRefresh = setInterval(() => {
//     let now = DateTime.now();
//     let diff = now.diff(lastTextRefresh).as('seconds');
//
//     dynamicRemaining.value -= diff;
//     dynamicRemaining.value = Math.max(dynamicRemaining.value, 0);
//
//     $("#label-remaining-time").text(dynamicRemaining.value.toFixed(2));
//     $("#countdown-score").text(score.value);
//     lastTextRefresh = now;
// }, SCORE_UPDATE_INTERVAL);

onMounted(() => {
    initIntervals();
})

onBeforeUnmount(() => {
    clearInterval(scoreTickInterval);
});
// watch(() => props.question.finished, async (finished, oldFinished) => {
//     console.log("countdown restart ? ", !finished);
//     if (!finished) {
//         let clockHand = document.getElementById('clock-hand');
//         if(clockHand === null)
//             return;
//         restartAnimation(clockHand, 'rotating');
//     }
// });

watch(() => props.question.id, (newId, oldId) => {
    if (newId === oldId)
        return;

    initIntervals();
});
</script>

<template>
    <div class="flex justify-center lg:py-10 sm:py-2 group">
        <div class="flex flex-col align-center items-center">
            <div class="relative flex items-center justify-end w-20 h-20 overflow-hidden rounded-full"
                 :class="[
            question.finished
            ? 'bg-red-500'
            : 'bg-gray-900'
        ]"
            >
                <div
                    id="clock-hand"
                    class="rotating absolute w-1/2 h-1 origin-left"
                >
                    <div class="w-5/6 h-full bg-white rounded-full">
                    </div>
                </div>

            </div>
            <div>{{ score }}</div>
<!--            <div id="label-remaining-time">{{ dynamicRemaining.toFixed(2) }}</div>-->
        </div>


    </div>
    <!--        <pre>total : {{ props.total }}</pre>-->
<!--    <pre>base remaining : {{ question.time_remaining_with_grace_period.toFixed(2) }}</pre>-->
<!--    <pre>clock duration : {{ clockDurationSeconds }}</pre>-->
<!--    <pre>clock delay : {{ clockDelay }}</pre>-->
</template>

<style scoped>
#clock-hand {
    transform: rotate(-90deg);
}

@keyframes rotating {
    from {
        transform: rotate(-90deg);
    }
    to {
        transform: rotate(270deg);
    }
}

.rotating {
    transform: rotate(-90deg);

    animation-delay: v-bind(clockDelay);
    animation-duration: v-bind(clockDurationSeconds);
    animation-name: rotating;
    animation-timing-function: linear;
}
</style>
