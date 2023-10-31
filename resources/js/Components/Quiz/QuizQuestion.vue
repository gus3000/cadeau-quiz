<script lang="ts" setup>
import {computed, type PropType} from "vue";
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

</script>

<template>
    <Countdown :total="question?.duration" :remaining="remainingSeconds" :question-finished="questionFinished"/>

    <p class="text-2xl font-bold">{{ question?.text ?? "Le quiz va bientôt commencer !" }}</p>
    <div v-if="questionFinished">Question terminée !</div>
    <div v-if="question" class="text-xl">Question {{ question.order + 1 }}</div>
    <label
        v-for="answer in question?.answers"
        class="block mt-4 border border-gray-300 grounded-lg py-2 px-6 text-lg"
        :class="{
                'bg-gray-200': questionFinished
            }"
    >
        <input
            class="answer"
            type="radio"
            name="{{question?.id}}"
            @change="selectAnswer(question,answer)"
            :disabled="questionFinished"
        />
        {{ answer.text }}
    </label>

</template>

<style scoped>

</style>
