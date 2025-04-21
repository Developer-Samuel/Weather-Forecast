<template>
  <div class="w-full h-auto">
    <div class="grid lg:grid-cols-4 md:grid-cols-3 sm:grid-cols-2 grid-cols gap-4 mt-4">
      <Item
        v-for="(city, index) in cities"
        :key="index"
        :city="city"
        :country="country"
      />
    </div>
  </div>
</template>

<script setup>
import Item from '@/Components/Cities/Item.vue';

const props = defineProps({
    country: String,
    cities: Array,
});
</script>
