<!--<script setup lang="ts">-->
<!--import {onMounted, PropType, ref} from "vue";-->
<!--import {jwtDecode} from "jwt-decode";-->
<!--import IconButton from "@/Components/Button/IconButton.vue";-->
<!--import {ArrowRightFromBracketIcon} from "flowbite-vue-icons";-->
<!--import $ from "jquery";-->
<!--import {User} from "@/Types";-->
<!--import {router} from "@inertiajs/vue3";-->
<!--import Fullscreen from "@/Pages/TwitchExtension/Fullscreen.vue";-->

<!--defineProps({-->
<!--    user: Object as PropType<User>,-->
<!--    windowType: String,-->
<!--});-->
<!--const jwtToken = ref({});-->

<!--function tryHome() {-->
<!--    router.visit('/dashboard');-->
<!--}-->

<!--onMounted(() => {-->
<!--    window.Twitch.ext.onAuthorized(function (auth) {-->
<!--        console.log("authorized !");-->
<!--        jwtToken.value = auth.token;-->
<!--        // const helixDecoded = jwtDecode(auth.helixToken);-->
<!--        // const jwtDecoded = jwtDecode(auth.token);-->
<!--        router.reload({-->
<!--            headers: {-->
<!--                "Authorization": `Bearer ${jwtToken.value}`-->
<!--            },-->
<!--        });-->
<!--        // debugNode.innerText = JSON.stringify(window.Twitch.ext.viewer.id);-->
<!--        // debugNode.innerText = auth.token;-->
<!--        // $("#debugToken").text(JSON.stringify(jwtDecoded,  null, 2));-->
<!--        // console.log('The Helix JWT is ', auth.helixToken);-->
<!--        // if(!debugNode)-->
<!--        //     return;-->
<!--        // debugNode.innerText = auth.userId;-->
<!--    });-->

<!--})-->
<!--</script>-->

<template>
<!--    <IconButton :icon-name="ArrowRightFromBracketIcon" text="test" @click="tryHome"/>-->
<!--    <pre id="debug"></pre>-->
<!--&lt;!&ndash;    <pre id="debugUser">user : {{ user ?? 'nope' }}</pre>&ndash;&gt;-->
<!--    <pre id="debugWindow">{{ windowType }}</pre>-->
<!--    <Component :is="Fullscreen" />-->
</template>

<!--<style scoped>-->
<!--pre {-->
<!--    color: white;-->
<!--}-->
<!--</style>-->
