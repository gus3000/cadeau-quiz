<script setup lang="ts">

defineProps({
  solid: {
    type: Boolean,
    required: true,
  },
  iconName: {
    type: String,
    required: true,
  }
});
</script>

<template>
  <Component :is="iconName" class="w-4 h-4" :class="$props.class"/>
</template>

<style scoped>

</style>
