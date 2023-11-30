<script setup lang="ts">
import {PropType} from "vue";
import {TPlayerStats, TStats} from "@/Model/TStats";
import Text from "@/Components/Text.vue";
import Table from "@/Components/Table.vue";
import {usePage} from "@inertiajs/vue3";

const page = usePage();

function textColor(stat: TPlayerStats) {
  return [
    stat.name === page.props.auth.user.name ? 'font-bold dark:text-blue-400' : 'text-slate-200'
  ]
}

const props = defineProps({
  stats: Object as PropType<TStats>,
});

</script>

<template>
  <div class="flex justify-center">
    <div class="w-1/2 rounded-xl bg-slate-50 dark:bg-slate-900">
      <div class="container my-4">
        <div class="name header">Nom</div>
        <div class="score header">Score</div>
        <div class="goodAnswers header">Bonnes réponses</div>
        <template v-for="stat in stats?.players">
          <div class="content name" :class="textColor(stat)">{{ stat.name }}</div>
          <Text class="content score" :class="textColor(stat)">{{ stat.score }}</Text>
          <Text class="content goodAnswers" :class="textColor(stat)">{{ stat.goodAnswers }}</Text>
        </template>
      </div>
    </div>
  </div>
</template>

<style scoped>
.container {
  display: grid;
  grid-template-columns: 2fr 1fr 1fr;
  grid-auto-flow: row;
}

.content {
  @apply dark:bg-slate-800 m-0 p-2 border-b border-slate-400 dark:border-slate-700;
}

.header {
  @apply font-bold text-slate-400 dark:text-slate-200 p-4;
}

.name {
  /*@apply dark:bg-slate-800;*/
}

.score {
}

.goodAnswers {
}

</style>
