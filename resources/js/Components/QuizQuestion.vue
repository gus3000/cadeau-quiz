<script lang="ts" setup>
import type {PropType} from "vue";
import type {TQuestion} from "@/Model/TQuestion";

function selectAnswer(answer) {
    console.log("selected : ", answer);
}

defineProps({question: Object as PropType<TQuestion>})
</script>

<template>
    <div class="bg-white p-12 rounded-lg shadow-lg w-full mt-8">
        <p class="text-2xl font-bold">{{ question.text }}</p>
        <label
            v-for="answer in question.answers"
            class="block mt-4 border border-gray-300 grounded-lg py-2 px-6 text-lg">
            <input
                class="answer"
                type="radio"
                name="{{question.id}}"
                @change="selectAnswer(answer)"
            />
            {{ answer.text }}
        </label>
    </div>
</template>

<style scoped>

</style>
