<script setup lang="ts">

import {computed, onMounted, ref, watch, watchEffect} from "vue";
import {TUser} from "@/Model/TUser";

const props = defineProps({
    quiz: {
        required: true,
    },
});

const users = ref(null);
const filter = ref(null);
const checkedUsers = ref([]);
onMounted(() => {
    axios.get(route('users.index')).then((response) => {
        users.value = response.data;
    });
    axios.get(route('api.quizzes.allowed-users', props.quiz as any)).then((response) => {
        checkedUsers.value = response.data.map((user: TUser) => user.id);
    })
})

function userSort(userA: TUser, userB: TUser) {
    return userA.name.localeCompare(userB.name);
}

const filteredUsers = computed(() => {
    console.log("recomputed filtered users with filter : ", filter.value);
    if (filter.value === null)
        return users.value?.sort(userSort);
    return users.value
        ?.filter((user) => user.name.toLowerCase().includes(filter.value.toLowerCase()))
        .sort(userSort);
})

function search(toSearch) {
    filter.value = toSearch;
}

watch(checkedUsers, () => {
    console.log("checked users set to", checkedUsers.value);
    axios.put(route('api.quizzes.allowed-users', props.quiz), {
        checkedUsers: checkedUsers.value
    }).then((response) => {
        console.log("allowed users changed : success !");
    });
});

</script>

<template>
    <div>

        <!-- Dropdown menu -->
        <div id="dropdownSearch" class="z-10 bg-white rounded-lg shadow w-60 dark:bg-gray-700">
            <div class="p-3">
                <label for="input-group-search" class="sr-only">Recherche</label>
                <div class="relative">
                    <div class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                             xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                        </svg>
                    </div>
                    <input type="text" id="input-group-search"
                           class="block w-full p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                           placeholder="Chercher un utilisateur"
                           @input="search($event.target.value)"
                    >
                </div>
            </div>
            <ul class="max-h-32 px-3 pb-3 overflow-y-auto text-sm text-gray-700 dark:text-gray-200"
                aria-labelledby="dropdownSearchButton">
                <li v-for="user in filteredUsers">
                    <div class="flex items-center ps-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600">
                        <input
                            :id="'authorized-user-' + user.id"
                            type="checkbox"
                            v-model="checkedUsers"
                            :name="'authorized-user-' + user.id"
                            :value="user.id"
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                        <label :for="'authorized-user-' + user.id"
                               class="w-full py-2 ms-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300">{{
                                user.name
                            }}</label>
                        <img class="w-6 h-6 me-2 rounded-full" :src="user.twitch_avatar" alt="Jese image">
                    </div>
                </li>
            </ul>
        </div>

    </div>
</template>

<style scoped>

</style>