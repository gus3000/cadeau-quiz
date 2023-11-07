<script setup lang="ts">

import DashboardLayout from "@/Layouts/DashboardLayout.vue";
import {router} from '@inertiajs/vue3'
import {computed, onMounted, onUnmounted, watch} from 'vue';
import type {TQuiz} from "@/Model/TQuiz";
import QuizQuestionEdit from "@/Components/Quiz/QuizQuestionEdit.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import InputText from "@/Components/LabeledTextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import LabeledTextInput from "@/Components/LabeledTextInput.vue";
import axios from "axios";
import {debounce} from "@/Services/Debounce";

const props = defineProps<{
    quiz: TQuiz,
    errors: TQuiz
}>();

function submit() {
    axios.put(route("quizzes.update", props.quiz), props.quiz);
}

const debounceSubmit = debounce(function () {
    submit();
}, 1000);

watch(props.quiz, async () => {
    console.log('watcher triggered');
    debounceSubmit();
});
</script>

<template>
    <DashboardLayout :title="quiz.name">
        <form
            class="divide-y divide-dashed divide-gray-700"
            @submit.prevent="submit"
        >
            <div>
                <LabeledTextInput
                    v-model="quiz.name"
                    name="pouet"
                    :error="errors.name"
                    label="Nom"
                />
                <LabeledTextInput
                    v-model="quiz.short_name"
                    name="pouet"
                    :error="errors.short_name"
                    label="Nom court (à supprimer)"
                />
            </div>
            <QuizQuestionEdit v-for="question in quiz.questions" :question="question"/>

            <div>
                <PrimaryButton>Sauvegarder</PrimaryButton>
            </div>
        </form>
    </DashboardLayout>
</template>

<style scoped>

</style>
