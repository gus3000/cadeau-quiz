<script setup lang="ts">
import type {TQuestion} from "@/Model/TQuestion";
import LabeledTextInput from "@/Components/Input/LabeledTextInput.vue";
import type {TAnswer} from "@/Model/TAnswer";
import QuizAnswerEdit from "@/Components/Quiz/QuizAnswerEdit.vue";
import {AngleDownIcon, AngleUpIcon, TrashBinIcon} from "flowbite-vue-icons";
import IconButton from "@/Components/Button/IconButton.vue";
import FileInput from "@/Components/Input/FileInput.vue";
import {onMounted, ref} from "vue";


const props = defineProps<{
    question: TQuestion,
    totalNumberOfQuestions: number,
}>();

const preview = ref(null);

function correctAnswers(): TAnswer[] {
    return props.question.answers.filter((answer) => answer.correct);
}

function incorrectAnswers(): TAnswer[] {
    return props.question.answers.filter((answer) => !answer.correct);
}

function changeFile(fileInput): void {
    console.log('file changed', fileInput);
    const formData = new FormData();
    formData.append("media", fileInput.target.files[0]);
    console.log("uploaded :", formData);
    axios.post(route('questions.media', props.question), formData, {
        headers: {
            'Content-Type': 'multipart/form-data',
        }
    }).then((response) => {
        console.log("reloading image");
        preview.value = response.data.file;
    });
}

onMounted(() => {
    preview.value = props.question?.media?.file;
})

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
        <FileInput label="Charger une image" accept="image/png, image/jpeg" :onchange="changeFile" :preview="preview"/>
        <QuizAnswerEdit v-for="answer in [...correctAnswers(), ...incorrectAnswers()]"
                        :answer="answer"
        />
    </div>
</template>

<style scoped>

</style>
