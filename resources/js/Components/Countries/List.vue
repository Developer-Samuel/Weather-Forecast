<template>
    <div class="w-full h-auto">
      <div class="grid lg:grid-cols-4 md:grid-cols-3 sm:grid-cols-2 grid-cols gap-4 mt-4">
        <Item
          v-for="(country, index) in countries"
          :key="index"
          :country="country"
        />
      </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import Item from '@/Components/Countries/Item.vue';

const props = defineProps({
    countries: Array,
});

const countries = ref(props.countries || []);
</script>
