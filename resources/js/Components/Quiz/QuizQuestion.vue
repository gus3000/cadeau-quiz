<script lang="ts" setup>
import {type PropType, ref, watch} from "vue";
import type {TQuestion} from "@/Model/TQuestion";
import type {TAnswer} from "@/Model/TAnswer";
import axios from "axios";
import Countdown from "@/Components/Quiz/VanillaCountdown.vue";
import type {TGuess} from "@/Model/TGuess";
import SnapCountdown from "@/Components/Quiz/SnapCountdown.vue";

const selectedAnswer = ref<TAnswer | null>(null);
const score = ref<number>(0);

function selectAnswer(answer: TAnswer) {
    const url = `/api/user/guess/${props.question?.id}/${answer.id}`;
    console.log("time remaining :", score.value);
    axios.put(url, {
        score: score.value
    })
        .then(() => {
            // console.log("select answer success");
            selectedAnswer.value = answer;
        }, () => {
            // console.log("select answer error");
        });

}

function answerClass(answer: TAnswer) {
    // console.log("guess answer", props.guess?.answer?.id);
    // console.log("answer", answer.id);
    if (answer.id === props.question?.correct_answer?.id)
        return ['radio-label-good'];
    if (answer.id === props.guess?.answer?.id)
        return ['radio-label-bad'];
    if (answer.id === selectedAnswer.value?.id)
        return ['radio-label-selected'];

    return ['radio-label-neutral'];

}

function updateScore(s: number) {
    score.value = s;
}

const props = defineProps({
    question: {
        type: Object as PropType<TQuestion>,
        required: true,
    },
    guess: Object as PropType<TGuess>,
    overlay: Boolean,
    questionFinished: Boolean,
});

watch(() => props.question?.id, (newId, oldId) => {
    if (newId === oldId)
        return;
    document.getElementsByName(`question-answer-${oldId}`).forEach((input: HTMLElement) => {
        (input as HTMLInputElement).checked = false;
    });
});

watch(() => props.question?.correct_answer, (newCorrect, oldCorrect) => {
    if (newCorrect === undefined) {
        // console.log("pas de triche !")
    } else {
        // console.log("new correct answer :", newCorrect)

    }
})
</script>

<template>
    <div>
        <p class="text-2xl font-bold my-1">{{ question?.text ?? "Le quiz va bientôt commencer !" }}</p>
        <!--        <div v-if="questionFinished">Question terminée !</div>-->
        <div v-if="question" class="text-xl" :class="[overlay ? 'hidden' : '']">Question {{ question.order }}</div>
        <ul class="grid grid-cols-2 place-items-stretch gap-2">
            <li v-for="answer in question?.answers"
                class="flex flex-1 w-full justify-center items-center"
            >
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
                    class="grow border border-gray-300 grounded-lg py-2 px-6 text-lg rounded-lg cursor-pointer text-center flex justify-between"
                    :class="answerClass(answer)"
                >
                    <div>{{ answer.text }}</div>
                    <div v-if="answer.guesses">{{ answer.guesses.length }}</div>
                </label>
            </li>
        </ul>
<!--        <SnapCountdown/>-->
        <Transition name="bounce">
            <Countdown
                v-if="!questionFinished"
                :question="question"
                @update-score="updateScore"
            />
        </Transition>
        <!--        <Gift/>-->
    </div>
</template>

<style scoped>
input[type=radio] {
    opacity: 0;
}

.cadeau-timer-container {
    display: flex;
    justify-content: center;
}

.cadeau-timer {
    background: black;
    color: white;
    border-radius: 100%;
    width: 100px;
    height: 100px;
    line-height: 100px;
    text-align: center;
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
