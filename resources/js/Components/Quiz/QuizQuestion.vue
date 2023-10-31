<script lang="ts" setup>
import {computed, type PropType, watch} from "vue";
import type {TQuestion} from "@/Model/TQuestion";
import {router} from "@inertiajs/vue3";
import type {TAnswer} from "@/Model/TAnswer";
import axios from "axios";
import Countdown from "@/Components/Quiz/Countdown.vue";

function selectAnswer(answer: TAnswer) {
    const url = `/api/user/guess/${props.question?.id}/${answer.id}`;
    axios.put(url);
}

function answerClass(answer: TAnswer) {
    if (!props.questionFinished || props.question?.correct_answer == null)
        return ['radio-label-neutral'];
    if(answer.id === props.question?.correct_answer?.id)
        return ['radio-label-good'];
    return ['radio-label-bad'];
}

const props = defineProps({
    question: Object as PropType<TQuestion>,
    questionFinished: Boolean,
    remainingSeconds: Number,
});

watch(() => props.question?.id, (newId, oldId) => {
    if (newId !== oldId) {
        document.getElementsByName(`question-answer-${oldId}`).forEach((input) => {
            input.checked = false;
        })
    }
});

watch(() => props.question?.correct_answer, (newCorrect, oldCorrect) => {
    if (newCorrect === undefined) {
        console.log("pas de triche !")
    } else {
        console.log("new correct answer :", newCorrect)

    }
})
</script>

<template>
    <Transition name="bounce">
        <Countdown v-show="!questionFinished" :total="question?.duration" :remaining="remainingSeconds"
                   :question-finished="questionFinished"/>
    </Transition>

    <p class="text-2xl font-bold">{{ question?.text ?? "Le quiz va bientôt commencer !" }}</p>
    <div v-if="questionFinished">Question terminée !</div>
    <div v-if="question" class="text-xl">Question {{ question.order + 1 }}</div>
    <ul>
        <li v-for="answer in question?.answers">
            <input
                :id="`answer-${answer.id}`"
                :name="`question-answer-${question.id}`"
                class="hidden peer"
                type="radio"
                @change="selectAnswer(answer)"
                :disabled="questionFinished"
            />
            <label
                :for="`answer-${answer.id}`"
                class="block mt-4 border border-gray-300 grounded-lg py-2 px-6 text-lg rounded-lg cursor-pointer
                 "
                :class="answerClass(answer)"
            >
                {{ answer.text }}
            </label>
        </li>
    </ul>

</template>

<style scoped>
input[type=radio] {
    opacity: 0;
}

.bounce-enter-active {
    animation: bounce-in 0.5s;
}

.bounce-leave-active {
    animation: bounce-in 0.5s reverse;
}

@keyframes bounce-in {
    0% {
        transform: scale(0);
    }
    50% {
        transform: scale(1.25);
    }
    100% {
        transform: scale(1);
    }
}
</style>
