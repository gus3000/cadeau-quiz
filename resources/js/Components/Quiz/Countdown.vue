<script setup lang="ts">

import {computed, onBeforeUnmount, type PropType, watch} from "vue";
import {DateTime} from "luxon";

import type {TQuestion} from "@/Model/TQuestion";
import {restartAnimation} from "@/Services/Animation";

const props = defineProps<{
    total: number,
    remaining: number,
    questionFinished: boolean,
}>();

let dynamicRemaining = props.remaining ?? 0;

const clockDurationSeconds = computed(() => {
    return `${props.total}s`;
});

const clockDelay = computed(() => {
    return `-${props.total - props.remaining}s`;
});

let lastTextRefresh = DateTime.now();
const textRefresh = setInterval(() => {
    let now = DateTime.now();
    let diff = now.diff(lastTextRefresh).as('seconds');

    dynamicRemaining -= diff;
    dynamicRemaining = Math.max(dynamicRemaining, 0);


    let el = document.getElementById('label-remaining-time');
    if (el)
        el.innerText = dynamicRemaining.toFixed(2);
    lastTextRefresh = now;
}, 50);

onBeforeUnmount(() => {
    clearInterval(textRefresh);
});
watch(() => props.questionFinished, async (finished, oldFinished) => {
    if (!finished) {
        let clockHand = document.getElementById('clock-hand');
        if(clockHand === null)
            return;
        restartAnimation(clockHand, 'rotating');
    }
});

watch(() => props.remaining, async (remaining: number) => {
    dynamicRemaining = remaining;
});
</script>

<template>
    <div class="flex justify-center py-10 group">
        <div class="flex flex-col align-center items-center">
            <div class="relative flex items-center justify-end w-20 h-20 overflow-hidden rounded-full"
                 :class="[
            questionFinished
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
            <div id="label-remaining-time">0</div>
        </div>


    </div>
    <!--    <pre>total : {{ props.total }}</pre>-->
    <!--    <pre>remaining : {{ props.remaining }}</pre>-->
    <!--    <pre>clock duration : {{ clockDurationSeconds }}</pre>-->
    <!--    <pre>clock delay : {{ clockDelay }}</pre>-->
</template>

<style scoped>


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
