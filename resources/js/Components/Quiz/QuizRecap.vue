<script setup lang="ts">
import type {TQuiz} from "@/Model/TQuiz";

import {LockClosedIcon, PencilSquareIcon} from "@heroicons/vue/24/outline";
import {Link} from "@inertiajs/vue3";

const props = defineProps<{
    quiz: TQuiz
}>();
</script>

<template>
    <div class="flex items-center space-x-4 pb-3 sm:py-4">
        <div class="flex-shrink-0">
            <img class="w-8 h-8 rounded-full" :src="quiz.logo_url ?? '/img/cadeau_logo.png'" alt="">

        </div>
        <div class="flex-1 min-w-0">
            <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                {{ quiz.name }}
            </p>
            <p class="text-sm text-gray-500 truncate dark:text-gray-400">

            </p>
        </div>
        <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
            <div v-if="quiz.locked">
                <button
                    class="h-6 w-6"
                    data-tooltip-target="tooltip-locked"
                >
                    <LockClosedIcon/>
                </button>
                <div id="tooltip-locked" role="tooltip" class="cadeau-tooltip">
                    Le quiz est verouillé, vous ne pouvez plus le modifier
                    <div class="tooltip-arrow" data-popper-arrow></div>
                </div>
            </div>
            <div v-else>
                <Link
                    class="h-6 w-6"
                    data-tooltip-target="tooltip-edit"
                    :href="route('quizzes.edit', {quiz: quiz})">
                    <PencilSquareIcon class="h-6 w-6 text-blue-500"/>
                </Link>
                <div id="tooltip-edit" role="tooltip" class="cadeau-tooltip">
                    Modifier le quiz
                    <div class="tooltip-arrow" data-popper-arrow></div>
                </div>
            </div>

        </div>
    </div>
</template>

<style scoped>

</style>
