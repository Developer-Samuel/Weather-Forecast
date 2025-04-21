<template>
    <div class="w-full bg-black border-2 border-solid border-black rounded-2xl">
      <a :href="url" class="w-full h-full flex justify-center items-center text-xl font-bold text-center px-4 py-6 text-white hover:underline">
        {{ name }}
      </a>
    </div>
  </template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
    item: Object,
});

const url = computed(() => {
    if (props.item.type === 'country') {
        return `/${encodeURIComponent(props.item.name)}`;
    } else if (props.item.type === 'city' && props.item.country) {
        return `/weather/${encodeURIComponent(props.item.country)}/${encodeURIComponent(props.item.name)}`;
    }
    return '#';
});

const name = computed(() => props.item.name);
</script>
