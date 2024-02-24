<script setup lang="ts">

import {Camera, GltfModel, PointLight, Renderer, Scene} from "troisjs";
import {ref} from "vue";

const renderer = ref(null);
const box = ref(null);
const gift = ref(null);

const onGiftReady = function () {
    if (renderer.value === null) {
        console.log("not ready")
        return;
    }

    renderer.value.onBeforeRender(() => {
        // gift.value.o3d.rotation.y += 0.02;
        // gift.value.o3d.rotation.x += 0.01;
        // console.log(gift.value);
    });
}
</script>

<template>
    <Renderer ref="renderer" :alpha="true" resize="window">
        <Camera :position="{ y:3, z: 10 }" :lookAt="gift?.position"/>
        <Scene background="">
            <PointLight :position="{ x:50, y: 50, z: 50 }"/>

            <GltfModel
                ref="gift"
                src="/glb/flask.glb"
                @load="onGiftReady"
                :position="{y: -2}"
            />
        </Scene>
    </Renderer>
</template>

<style scoped>

</style>