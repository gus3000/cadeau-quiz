<script setup lang="ts">
import {Bar} from "vue-chartjs"
import {BarElement, CategoryScale, Chart as ChartJS, Legend, LinearScale, Title, Tooltip} from 'chart.js'
import {ref, computed} from "vue";

ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale);

const chartOptions = ref({
  responsive: true,
});

const props = defineProps({
  chartData: Array,
});

const chartData = computed(() =>
{
  return {
    labels: ['January', 'February', 'March'],
    datasets: [{data: props.chartData}]
  };
});
;
</script>

<template>
<Bar
id="pouet"
:options="chartOptions"
:data="chartData"
/>
</template>

<style scoped>

</style>
