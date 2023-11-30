<script setup lang="ts">
// import * as THREE from 'three'
import {onMounted, ref} from "vue";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

const renderer = ref(null);
const box = ref(null);
const gift = ref(null);

const onGiftReady = function() {
    if(renderer.value === null) {
        console.log("not ready")
        return;
    }

    renderer.value.onBeforeRender(() => {
        // box.value.mesh.rotation.x += 0.1;
        gift.value.o3d.rotation.y += 0.02;
        // console.log(gift.value);
    });
}

onMounted(() => {

})
</script>

<template>
    <AuthenticatedLayout>
    <Renderer ref="renderer" :alpha="true" resize="window">
        <Camera :position="{ y:3, z: 10 }" :lookAt="gift?.position" />
        <Scene background="">
            <PointLight :position="{ y: 50, z: 50 }" />

            <GltfModel
                ref="gift"
                src="/glb/GiftBox.glb"
                @load="onGiftReady"
                :position="{y: -2}"
            />
        </Scene>
    </Renderer>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>