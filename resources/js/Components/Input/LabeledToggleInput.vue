<script setup lang="ts">

import Toggle from "@/Components/Toggle.vue";
import {computed} from "vue";
import InputLabel from "@/Components/Input/InputLabel.vue";

const emit = defineEmits(['update:modelValue']);

const props = defineProps({
    modelValue: {
        type: [Boolean, Number],
        required: true,
    },
    label: String,
});

function change(val: Boolean) {
    console.log("function toggle set to", val);
    emit('update:modelValue', val);
}

const proxyChecked = computed({
    get() {
        return props.modelValue === true || props.modelValue === 1;
    },
    set(val) {
        console.log("proxychecked set to ", val);
    }
})
</script>

<template>
    <div class="text-center">
        <div class="md:flex md:items-center mt-4 mb-2 px-4">
            <div class="md:w-1/4">
                <InputLabel :for="modelValue" :value="label"/>
            </div>
            <div class="md:w-3/4 text-left">
                <Toggle :checked="proxyChecked"
                        :value="proxyChecked"
                        @update:checked="change"
                />
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>