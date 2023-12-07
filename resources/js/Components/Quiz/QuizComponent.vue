<script setup lang="ts">

import {onMounted, PropType, ref} from "vue";
import type {TQuiz} from "@/Model/TQuiz";
import type {TQuestion} from "@/Model/TQuestion";
import {TGuess} from "@/Model/TGuess";
import QuizQuestion from "@/Components/Quiz/QuizQuestion.vue";
import {router} from "@inertiajs/vue3";
import {TStats} from "@/Model/TStats";
import QuizStats from "@/Components/Quiz/QuizStats.vue";

const props = defineProps({
    quiz: Object as PropType<TQuiz>,
    question: Object as PropType<TQuestion>,
    guess: Object as PropType<TGuess>,
    stats: Object as PropType<TStats>,
    overlay: {
        type: Boolean,
        default: false,
    },
    questionFinished: Boolean,
});

const showStats = ref(false);

onMounted(() => {
    Echo.private('quiz.flow')
        .listen('ShowStats', (e: any) => {
            console.log("SHOW STATS", e);
            router.reload({
                only: ['stats'],
                onFinish: () => {
                    showStats.value = true;
                }
            });

        })
        .listen('NextQuestion', (e: any) => {
            console.log("NEXT QUESTION", e);
            showStats.value = false;
            // console.log("question id before :", props.question?.id);
            router.reload({
                only: ['quiz', 'question'], onFinish: () => {
                    // console.log("question id after :", props.question.id);

                }
            })
        })
        .listen('QuestionClosed', () => {
            console.log("Question closed !");
            router.reload({only: ['question', 'guess']});
        });
})
</script>

<template>
    <div class="lg:py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg my-2">
                <div
                    v-if="!question || !overlay"
                    class="px-6 py-6 text-gray-900 dark:text-gray-100">{{ quiz?.name }}
                </div>
                <div class="bg-white px-12 lg:py-12 sm:py-2 rounded-lg shadow-lg w-full">
                    <Transition name="slide" mode="out-in">
                        <QuizQuestion
                            v-if="question && !showStats"
                            v-bind="{question, guess, questionFinished, overlay}"
                        />
                        <QuizStats
                            v-else-if="showStats"
                            :stats="stats"
                        />
                        <div v-else-if="quiz?.finished">
                            Quiz terminé !
                        </div>
                        <div v-else-if="quiz">
                            Le quiz va bientôt démarrer...
                        </div>
                        <div v-else>
                            Pas de quiz en cours, mais du coup vous ne devriez pas voir ceci.
                        </div>
                    </Transition>

                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.slide-enter-active {
    transition: all 0.3s ease-out;
}

.slide-leave-active {
    transition: all 0.5s cubic-bezier(1, 0.5, 0.8, 1);
}

.slide-enter-from, .slide-leave-to {
    transform: translateY(50px);
    opacity: 0;
}
</style>
