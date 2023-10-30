<script setup lang="ts">

defineProps({
    seconds: Number
});
</script>

<template>
    <div class="flex justify-center py-10 group">
        <div class="relative flex items-center justify-end w-20 h-20 overflow-hidden bg-gray-900 rounded-full ">
            <div
                id="clock-hand"
                class="absolute w-1/2 h-1 origin-left"
            >
                <div class="w-5/6 h-full bg-white rounded-full"/>
            </div>

        </div>
    </div>
</template>

<style scoped>


@keyframes rotating
{
    from
    {
        transform: rotate(-90deg);
    }
    to
    {
        transform: rotate(270deg);
    }
}
#clock-hand
{
    transform: rotate(-90deg);

    animation-duration: v-bind(seconds);
    animation-name: rotating;
    animation-iteration-count: infinite;
    animation-timing-function: linear;
    //animation: rotating v-bind(seconds) linear infinite;
}
</style>
