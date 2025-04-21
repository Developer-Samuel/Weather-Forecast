<template>
    <Link :href="`/${formatValue(country.name)}`" class="border-2 border-solid border-white hover:bg-white hover:text-black transition-linear duration-500 p-2">
      <p class="text-lg font-bold text-center">{{ formatName(country.name) }}</p>
    </Link>
  </template>

<script setup>
import { defineProps } from 'vue';
import { Link } from '@inertiajs/inertia-vue3';

const props = defineProps({
    country: Object,
});

const formatName = (name) => {
    return name
        .split(' ')
        .map(word => word.charAt(0).toUpperCase() + word.slice(1).toLowerCase())
        .join(' ');
    };

const formatValue = (value) => {
return value
    .toLowerCase()
    .replace(/\s+/g, '-')
};
</script>
