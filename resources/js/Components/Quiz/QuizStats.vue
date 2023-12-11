<script setup lang="ts">
import {computed, PropType, ref} from "vue";
import {TPlayerStats, TStats, TStatsType} from "@/Model/TStats";
import Text from "@/Components/Text.vue";
import {usePage} from "@inertiajs/vue3";
import {compute} from "three/examples/jsm/nodes/shadernode/ShaderNodeBaseElements";
import QuizStatsRow from "@/Components/QuizStatsRow.vue";

const SHOW_TOP_N_PLAYERS = 5;

const page = usePage();

const props = defineProps({
  stats: {
    type: Object as PropType<TStats>,
    required: true
  },
});

const playerRank = computed(() => {
  const name = page.props.auth.user.name;
  for (let [rank, playerStat] of props.stats?.players?.entries() ?? []) {
    if (playerStat.name === name)
      return rank;
  }
  return -1;
});

const playerStats = computed<TPlayerStats>(() => {
  const name = page.props.auth.user.name;
  for (let [rank, playerStat] of props.stats?.players?.entries() ?? []) {
    if (playerStat.name === name)
      return playerStat;
  }
  return -1;
})

const showAllStats = ref(false);


</script>

<template>
  <div class="flex justify-center">
    <div class="w-full rounded-xl bg-slate-50 dark:bg-slate-900">
      <Text class="text-center">Score {{ stats?.statsType === TStatsType.Quiz ? 'quiz' : 'question' }}
      </Text>
      <div class="container my-4" :class="[stats?.statsType === TStatsType.Quiz ? 'quiz' : 'question']">
        <QuizStatsRow :stats-type="stats?.statsType"
                      header
                      rank="Rang"
                      name="Nom"
                      score="Score"
                      good-answers="Bonnes réponses"
        />
        <template v-for="(stat,index) in showAllStats ? stats.players : stats?.players.slice(0,SHOW_TOP_N_PLAYERS)">
          <QuizStatsRow :stats-type="stats?.statsType"
                        :rank="index+1"
                        :name="stat.name"
                        :score="stat.score"
                        :good-answers="stat.goodAnswers"
                        :user="stat.name === page.props.auth.user.name"
          />
        </template>
        <QuizStatsRow v-if="playerRank > SHOW_TOP_N_PLAYERS && !showAllStats" :stats-type="stats.statsType" @click="() => {showAllStats = true;}" />

        <QuizStatsRow v-if="playerRank >= SHOW_TOP_N_PLAYERS && !showAllStats"
                      :stats-type="stats.statsType"
                      :rank="playerRank+1"
                      :name="playerStats.name"
                      :score="playerStats.score"
                      :good-answers="playerStats.goodAnswers"
                      :user="true"
        />
        <template  v-if="playerRank < stats.players.length -1 && !showAllStats">
          <QuizStatsRow :stats-type="stats.statsType" @click="() => {showAllStats = true;}"/>
        </template>
<!--        <template v-else-if="playerRank < stats.players.length">-->
<!--          <QuizStatsRow :stats-type="stats.statsType"-->
<!--            rank="bla"/>-->
<!--        </template>-->


      </div>
    </div>
  </div>
</template>

<style scoped>
.container {
  display: grid;
  grid-auto-flow: row;
}

.container.quiz {
  grid-template-columns: 0.5fr 2fr 1fr 1fr;
}

.container.question {
  grid-template-columns: 0.5fr 2fr 1fr;
}
</style>
