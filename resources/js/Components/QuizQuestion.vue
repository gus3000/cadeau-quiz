<script lang="ts" setup>
import type {PropType} from "vue";
import type {TQuestion} from "@/Model/TQuestion";
import {router} from "@inertiajs/vue3";
import type {TAnswer} from "@/Model/TAnswer";
import axios from "axios";

function selectAnswer(question: TQuestion, answer: TAnswer) {
    const url = `/api/user/guess/${question?.id}/${answer.id}`;
    axios.put(url);
    // router.put();
}

defineProps({question: Object as PropType<TQuestion>})
</script>

<template>
    <div class="bg-white p-12 rounded-lg shadow-lg w-full mt-8">
        <p class="text-2xl font-bold">{{ question?.text ?? "Le quiz va bientôt commencer !" }}</p>
        <div v-if="question?.finished">Question terminée !</div>
        <div v-if="question" class="text-xl">Question {{question.order + 1}}</div>
        <label
            v-for="answer in question?.answers"
            class="block mt-4 border border-gray-300 grounded-lg py-2 px-6 text-lg"
            :class="{
                'bg-gray-200': question?.finished
            }"
        >
            <input
                class="answer"
                type="radio"
                name="{{question?.id}}"
                @change="selectAnswer(question,answer)"
                :disabled="!question?.open"
            />
            {{ answer.text }}
        </label>
    </div>
</template>

<style scoped>

</style>
