<script setup lang="ts">
import type {TQuestion} from "@/Model/TQuestion";
import LabeledTextInput from "@/Components/LabeledTextInput.vue";
import TextInput from "@/Components/TextInput.vue";
import Checkbox from "@/Components/Checkbox.vue";
import ColorcodedCheckbox from "@/Components/Toggle.vue";
import Toggle from "@/Components/Toggle.vue";

const props = defineProps<{
  question: TQuestion
}>();
</script>

<template>
  <div>
    <div class="block text-gray-500 dark:text-gray-300 font-bold m-5 pr-4">Question {{ question.order }}</div>
<!--    <pre class="text-gray-50">{{question.correct_answer}}</pre>-->
    <LabeledTextInput label="Énoncé" v-model="question.text"/>
    <div v-for="answer in question.answers" class="md:flex items-center mt-4 mb-2 px-4 md:gap-5">
      <div class="md:w-1/4 flex justify-end">
        <Toggle :checked="answer.correct"/> <!-- FIXME remplacer ça par un radio -->
      </div>
      <div class="md:w-3/4">
        <TextInput v-model="answer.text"/>
      </div>
    </div>
    <!--    <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">-->
    <!--        <input type="text" v-model="question.text"/>-->
    <!--            <input type="text" v-model="answer.text"/>-->
    <!--        </div>-->
    <!--    </div>-->
  </div>
</template>

<style scoped>

</style>
