<script lang="ts" setup>
import {computed, type PropType, watch} from "vue";
import type {TQuestion} from "@/Model/TQuestion";
import {router} from "@inertiajs/vue3";
import type {TAnswer} from "@/Model/TAnswer";
import axios from "axios";
import Countdown from "@/Components/Quiz/Countdown.vue";

function selectAnswer(question: TQuestion, answer: TAnswer) {
    const url = `/api/user/guess/${question?.id}/${answer.id}`;
    axios.put(url);
}

const props = defineProps({
    question: Object as PropType<TQuestion>,
    questionFinished: Boolean,
    remainingSeconds: Number,
})
watch(() => props.question.id, (newId, oldId) => {
    if (newId !== oldId) {
        document.getElementsByName(`question-answer-${oldId}`).forEach((input) => {
            input.checked = false;
        })
    }
});
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
                @change="selectAnswer(question,answer)"
                :disabled="questionFinished"
            />
            <label
                :for="`answer-${answer.id}`"
                class="block mt-4 border border-gray-300 grounded-lg py-2 px-6 text-lg
                 text-gray-800 bg-white border border-gray-200 rounded-lg cursor-pointer
                 peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-gray-1000 hover:bg-gray-100"
                :class="{
                'bg-gray-200': questionFinished
            }"
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
