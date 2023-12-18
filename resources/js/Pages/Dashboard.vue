<script setup lang="ts">
import DashboardLayout from "@/Layouts/DashboardLayout.vue";
import {Bar} from 'vue-chartjs'
import {computed, ref} from "vue";
import LabelButton from "@/Components/Button/LabelButton.vue";
import PieBar from "@/Components/Chart/PieBar.vue";

const a = ref(40);
const b = ref(20);
const c = ref(12);

const chartData = computed((a,b,c) => [a,b,c]);
</script>

<template>
    <DashboardLayout title="Statistiques">
        <div class="p-6 text-gray-900 dark:text-gray-100">insérer Statistiques ici</div>
        <LabelButton text="Increment" @click="" />
        <PieBar
            id="user-stats"
            :chartData="chartData"
        />
    </DashboardLayout>
</template>
