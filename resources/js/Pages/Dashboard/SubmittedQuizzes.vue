<script setup lang="ts">

import DashboardLayout from "@/Layouts/DashboardLayout.vue";
import QuizRecap from "@/Components/Quiz/QuizRecap.vue";
import type {TQuiz} from "@/Model/TQuiz";
import IconButton from "@/Components/Button/IconButton.vue";
import {PlusIcon} from "flowbite-vue-icons";
import { Link } from '@inertiajs/vue3';
import {onMounted} from "vue";
import {initFlowbite} from "flowbite";
import Text from "@/Components/Text.vue";

const props = defineProps<{
    quizzes: TQuiz[]
}>();
</script>

<template>
    <DashboardLayout title="Mes quiz">
        <div class="p-6 text-gray-900 dark:text-gray-100 gap-4">
            <div class="divide-y divide-gray-200 dark:divide-gray-700 flex flex-col items-center">
                <QuizRecap v-for="quiz in quizzes" :quiz="quiz" class="h-10 w-80"/>
                <Text v-if="!quizzes.length">Pas de quiz proposé pour l'instant !</Text>
            </div>
        </div>
    </DashboardLayout>
</template>

<style scoped>

</style>
