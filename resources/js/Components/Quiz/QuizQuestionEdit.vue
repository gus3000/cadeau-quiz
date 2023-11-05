<script setup lang="ts">
import type {TQuestion} from "@/Model/TQuestion";

const props = defineProps<{
    question: TQuestion
}>();
</script>

<template>
    <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <input type="text" v-model="question.text"/>
<!--        <div v-for="answer in question.answers">-->
<!--            <input type="text" v-model="answer.text"/>-->
<!--        </div>-->
    </div>
</template>

<style scoped>

</style>
