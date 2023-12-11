<script setup lang="ts">

import {TPlayerStats, TStatsType} from "@/Model/TStats";
import Text from "@/Components/Text.vue";
import {computed, PropType} from "vue";
import {usePage} from "@inertiajs/vue3";

defineEmits(['click']);
const props = withDefaults(defineProps<{
  statsType: TStatsType,
  rank?: number | string,
  name?: string,
  score?: number | string,
  goodAnswers?: number | string | null,
  user?: boolean,
  header?: boolean,
}>(), {
  rank: '...',
  name: '...',
  score: '...',
  goodAnswers: '...',
  user: false,
  header: false,
});

const page = usePage();

const textClass = computed(() => {
  return [
    props.header ? 'header' : 'content',
    props.user ? 'user' : '',


  ];
});

</script>

<template>
  <div :class="textClass" @click="$emit('click')">{{ rank }}</div>
  <div :class="textClass" @click="$emit('click')">{{ name }}</div>
  <div :class="textClass" @click="$emit('click')">{{ score }}</div>
  <div :class="textClass" @click="$emit('click')" v-if="statsType === TStatsType.Quiz" class="goodAnswers">{{ goodAnswers }}</div>
</template>

<style scoped>
div {

}

.content {
  @apply dark:bg-slate-800 m-0 p-2 border-b border-slate-400 dark:border-slate-700 text-slate-400 dark:text-slate-200;
}

.content.user {
  @apply font-bold text-blue-400 dark:text-blue-400;
}

.header {
  @apply font-bold text-slate-400 dark:text-slate-200 p-4;
}

/*.name {
  !*@apply dark:bg-slate-800;*!
}

.score {
}

.goodAnswers {
}*/
</style>