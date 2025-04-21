<template>
  <Link :href="`/weather/${formatValue(country)}/${formatValue(city.name)}`" class="border-2 border-solid border-white hover:bg-white hover:text-black transition-linear duration-500 p-2">
    <p class="text-lg font-bold text-center">{{ formatName(city.name) }}</p>
  </Link>
</template>

<script setup>
import { defineProps } from 'vue';
import { Link } from '@inertiajs/inertia-vue3';

const props = defineProps({
  country: String,
  city: Object,
});

const formatName = (name) => {
  return name
    .split(' ')
    .map(word => word.charAt(0).toUpperCase() + word.slice(1).toLowerCase())
    .join(' ');
};

const formatValue = (value) => {
  if (!value) return '';
  return value.toLowerCase().replace(/\s+/g, '-');
};
</script>