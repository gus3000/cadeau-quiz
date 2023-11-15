<script setup lang="ts">

import DashboardLayout from "@/Layouts/DashboardLayout.vue";
import {computed, onMounted, Ref, ref, watch} from 'vue';
import type {TQuiz} from "@/Model/TQuiz";
import QuizQuestionEdit from "@/Components/Quiz/QuizQuestionEdit.vue";
import LabeledTextInput from "@/Components/Input/LabeledTextInput.vue";
import axios from "axios";
import {debounce} from "@/Services/Debounce";
import type {TQuestion} from "@/Model/TQuestion";
import {ArrowRightFromBracketIcon, CheckIcon, CloudArrowUpIcon, PlusIcon} from "flowbite-vue-icons";
import SizedIcon from "@/Components/SizedIcon.vue";
import Spinner from "@/Components/Icon/Spinner.vue";
import {DateTime} from "luxon";
import IconButton from "@/Components/Button/IconButton.vue";
import LabeledIntInput from "@/Components/Input/LabeledIntInput.vue";
import Modal from "@/Components/Modal.vue";
import {router} from "@inertiajs/vue3";
import Text from "@/Components/Text.vue";
import LabelButton from "@/Components/Button/LabelButton.vue";


const props = defineProps<{
    quiz: TQuiz,
    errors: any,
}>();

let isDirty = ref(false);
let lastUpdate: Ref<DateTime> = ref(DateTime.fromISO(props.quiz.updated_at));

let formattedLastUpdate: Ref<string> = ref('');
updateFormattedLastUpdate();

function updateFormattedLastUpdate() {
    formattedLastUpdate.value = lastUpdate.value.setLocale('fr').toRelative() ?? '';
}

function submit() {
    axios.put(route("quizzes.update", props.quiz as any),
        props.quiz
    ).then(() => {
        lastUpdate.value = DateTime.now();
        isDirty.value = false;
        updateFormattedLastUpdate();
    });
}

const debounceSubmit = debounce(function () {
    submit();

}, 1000);

const orderedQuestions = computed(
    () => {
        return props.quiz.questions.sort((a, b) => a.order - b.order);
    }
);

const confirmingQuizLock = ref(false);
const confirmQuizLock = () => {
    confirmingQuizLock.value = true;
};

const confirmingQuizLaunch = ref(false);
const confirmQuizLaunch = () => {
    confirmingQuizLaunch.value = true;
}

function normalizeOrders() {
    for (let [i, question] of props.quiz.questions.entries()) {
        question.order = i + 1;
    }
}

function exchangeQuestions(order1: number, order2: number) {
    console.log("exchanging questions", order1, "and", order2);
    normalizeOrders();
    const nbQuestions = props.quiz.questions.length;
    if (order1 < 1 || order2 < 1 || order1 >= nbQuestions || order2 >= nbQuestions)
        return;
    let question1 = props.quiz.questions.filter((q) => q.order === order1)[0];
    let question2 = props.quiz.questions.filter((q) => q.order === order2)[0];
    console.log('questions :', question1, question2);
    question1.order = order2;
    question2.order = order1;
}

function moveUp(question: TQuestion): void {
    console.log("move up", question);
    exchangeQuestions(question.order, question.order - 1);
}

function moveDown(question: TQuestion): void {
    exchangeQuestions(question.order, question.order + 1);
}

function addQuestion(): void {
    let questionRaw = {
        created_at: DateTime.now(),
        quiz_id: props.quiz.id,
        order: props.quiz.questions.length + 1,
        text: '',
    }
    axios.get(route('questions.create'), {params: questionRaw}).then((response) => {
        props.quiz.questions.push(response.data);
    });
}

function deleteQuestion(question: TQuestion): void {
    // console.log("deleting question", question);
    const i = props.quiz.questions.indexOf(question);
    props.quiz.questions.splice(i, 1);
    axios.delete(route('questions.destroy', question as any));
    normalizeOrders();
}

function lockQuiz(): void {
    axios.post(route("api.quizzes.lock", props.quiz as any)).then(() => {
        router.visit(route('quizzes.index'))
    });
}

function launchQuiz(): void {
    axios.get(route("api.quiz.open", props.quiz as any)).then(() => {
        router.visit(route('home'));
    });
}

const closeModalQuizLock = () => {
    confirmingQuizLock.value = false;
};

const closeModalQuizLaunch = () => {
    confirmingQuizLaunch.value = false;
}

onMounted(() => {
    setInterval(() => {
        updateFormattedLastUpdate();
    }, 1000);
    normalizeOrders();

    watch(props.quiz, async () => {
        isDirty.value = true;
        console.log('watcher triggered');
        debounceSubmit();
    });
});
</script>

<template>
    <DashboardLayout :title="quiz.name">
        <template v-slot:title>
            <div class="flex flex-row items-center gap-3">
                <span>{{ quiz.name }}</span>
                <Spinner v-show="isDirty"/>
                <div v-show="!isDirty">
                    <div data-tooltip-target="tooltip-saved">
                        <SizedIcon
                            :icon-name="CheckIcon"
                            :solid="true"
                        />
                    </div>
                    <div id="tooltip-saved" role="tooltip"
                         class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                        Dernière sauvegarde automatique {{ formattedLastUpdate }}
                        <div class="tooltip-arrow" data-popper-arrow></div>
                    </div>
                </div>
            </div>
        </template>
        <form
            class="divide-y divide-dashed divide-gray-700"
            @submit.prevent="submit"
        >
            <div>
                <LabeledTextInput
                    v-model="quiz.name"
                    name="quiz.name"
                    :error="errors.name"
                    label="Nom"
                />
                <LabeledIntInput
                    v-model.number="quiz.default_duration"
                    name="quiz.default_duration"
                    :error="errors.default_duration"
                    label="Durée par défaut d'une question"/>
                <LabeledIntInput
                    v-model.number="quiz.default_number_of_answers"
                    name="quiz.default_number_of_answers"
                    :error="errors.default_number_of_answers"
                    label="Nombre de réponses par défaut"/>
                <input type="hidden" v-model="quiz.updated_at"/>
            </div>

            <QuizQuestionEdit
                v-for="question in orderedQuestions"
                :question="question"
                @move-up="moveUp"
                @move-down="moveDown"
                @delete="deleteQuestion"
                :total-number-of-questions="quiz.questions.length"
            />

            <div class="flex flex-fill justify-center items-center py-4">
                <IconButton :icon-name="PlusIcon" text="Ajouter une question" @click="addQuestion()"/>
            </div>

            <template v-if="!$page.props.auth.user.admin">
                <div class="flex flex-fill justify-center items-center py-4">
                    <IconButton :icon-name="CloudArrowUpIcon" text="Soumettre le quiz" @click="confirmQuizLock"/>
                </div>
                <Modal :show="confirmingQuizLock" @close="closeModalQuizLock">
                    <div class="p-6">
                        <Text>Voulez-vous envoyer le quiz à Antho ?</Text>
                        <Text>Le quiz sera verrouillé et vous ne pourrez plus le modifier.</Text>
                        <div class="flex flex-fill justify-center items-center py-4">
                            <LabelButton text="Envoyer le quiz" @click="lockQuiz"/>
                        </div>
                    </div>
                </Modal>
            </template>
            <template v-else>
                <div class="flex flex-fill justify-center items-center py-4">
                    <IconButton :icon-name="ArrowRightFromBracketIcon" text="Lancer ce quiz" @click="confirmQuizLaunch"/>
                </div>
                <Modal :show="confirmingQuizLaunch" @close="closeModalQuizLaunch">
                    <div class="p-6">
                        <Text>Voulez-vous lancer ce quiz ?</Text>
                        <div class="flex flex-fill justify-center items-center py-4">
                            <LabelButton text="Lancer ce quiz" @click="launchQuiz"/>
                        </div>
                    </div>
                </Modal>
            </template>
            <!-- Draggable version, not finished but would be nice to have -->
            <!--      <draggable-->
            <!--          tag="transition-group"-->
            <!--          :list="quiz.questions"-->
            <!--          class="list-group"-->
            <!--          handle=".handle"-->
            <!--          item-key="name"-->
            <!--      >-->
            <!--        <template #item="{element}">-->
            <!--          <li>-->
            <!--            <IconButton :icon-name="BarsIcon" :solid="true" class="handle"/>-->
            <!--            <QuizQuestionEdit-->
            <!--                :question="element"-->
            <!--                @move-up="moveUp"-->
            <!--                @move-down="moveDown"-->
            <!--                :total-number-of-questions="quiz.questions.length"-->
            <!--            />-->
            <!--          </li>-->
            <!--        </template>-->
            <!--      </draggable>-->


        </form>
    </DashboardLayout>
</template>

<style scoped>
.handle {
    float: left;
    padding-top: 8px;
    padding-bottom: 8px;
}
</style>
