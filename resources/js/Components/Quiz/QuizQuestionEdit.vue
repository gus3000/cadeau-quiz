<script setup lang="ts">
import type {TQuestion} from "@/Model/TQuestion";
import LabeledTextInput from "@/Components/Input/LabeledTextInput.vue";
import type {TAnswer} from "@/Model/TAnswer";
import QuizAnswerEdit from "@/Components/Quiz/QuizAnswerEdit.vue";
import {AngleDownIcon, AngleUpIcon, TrashBinIcon} from "flowbite-vue-icons";
import IconButton from "@/Components/Button/IconButton.vue";


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

                <IconButton :icon-name="TrashBinIcon"
                            :solid="false"
                @click="$emit('delete', question)"
                />

                <IconButton :icon-name="AngleUpIcon"
                            :solid="false"
                            @click="$emit('moveUp', question)"
                            :disabled="question.order <= 1"/>

                <IconButton :icon-name="AngleDownIcon"
                            :solid="false"
                            @click="$emit('moveDown', question)"
                            :disabled="question.order >= totalNumberOfQuestions"/>

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
