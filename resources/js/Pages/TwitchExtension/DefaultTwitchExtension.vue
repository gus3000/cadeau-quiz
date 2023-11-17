<script setup lang="ts">
import {onMounted, PropType, ref, watch} from "vue";
import {jwtDecode} from "jwt-decode";
import IconButton from "@/Components/Button/IconButton.vue";
import {ArrowRightFromBracketIcon} from "flowbite-vue-icons";
import $ from "jquery";
import {User} from "@/Types";
import {router} from "@inertiajs/vue3";
import Fullscreen from "@/Pages/TwitchExtension/Fullscreen.vue";

defineProps({
    user: Object as PropType<User>,
});
const jwtToken = ref({});

function tryHome() {
    router.visit('/dashboard');
}

onMounted(() => {
    window.Twitch.ext.onAuthorized(function (auth) {
        console.log("authorized !");
        jwtToken.value = auth.token;
        // const helixDecoded = jwtDecode(auth.helixToken);
        // const jwtDecoded = jwtDecode(auth.token);

        router.reload({
            headers: {
                "Authorization": `Bearer ${jwtToken.value}`
            },
        });
        // debugNode.innerText = JSON.stringify(window.Twitch.ext.viewer.id);
        // debugNode.innerText = auth.token;
        // $("#debugToken").text(JSON.stringify(jwtDecoded,  null, 2));
        // console.log('The Helix JWT is ', auth.helixToken);
        // if(!debugNode)
        //     return;
        // debugNode.innerText = auth.userId;
    });
})

watch(jwtToken, () => {
    axios.interceptors.request.use(function (config) {
        config.headers.Authorization =  `Bearer ${jwtToken.value}`;

        return config;
    });
})
</script>

<template>
<!--    <IconButton :icon-name="ArrowRightFromBracketIcon" text="test" @click="tryHome"/>-->
<!--    <pre id="debug"></pre>-->
    <!--    <pre id="debugUser">user : {{ user ?? 'nope' }}</pre>-->
</template>

<style scoped>
pre {
    color: white;
}
</style>
