<script setup lang="ts">
import type {TQuestion} from "@/Model/TQuestion";
import LabeledTextInput from "@/Components/LabeledTextInput.vue";
import type {TAnswer} from "@/Model/TAnswer";
import QuizAnswerEdit from "@/Components/Quiz/QuizAnswerEdit.vue";



const props = defineProps<{
    question: TQuestion,
    totalNumberOfQuestions: number,
}>();

function correctAnswers(): TAnswer[] {
    return props.question.answers.filter((answer) => answer.correct);
}

function incorrectAnswers(): TAnswer[] {
    return props.question.answers.filter((answer) => !answer.correct);
}

</script>

<template>
    <div>
        <div class="flex flex-fill justify-between items-center">
            <div class="block text-gray-500 dark:text-gray-300 font-bold m-5 pr-4">Question {{ question.order }}</div>
            <div class="px-4 flex gap-2">
                <button class="btn btn-neutral p-2" @click="$emit('moveUp', question)"
                        :disabled="question.order <= 1">
                </button>
                <button class="btn btn-neutral p-2" @click="$emit('moveDown', question)">
                    <!--                    <AngleDown class="h-3"/>-->
                </button>
            </div>
        </div>

        <LabeledTextInput label="Énoncé" v-model="question.text"/>
        <QuizAnswerEdit v-for="answer in [...correctAnswers(), ...incorrectAnswers()]"
                        :answer="answer"
        />
    </div>
</template>

<style scoped>

</style>
