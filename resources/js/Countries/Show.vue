<template>
    <div class="w-full h-auto px-4">
        <div class="flex justify-center sm:py-8 pt-12 pb-8">
            <p class="text-3xl font-bold text-center">
                Cities of {{ country }}
            </p>
        </div>
        <Cities :country="country" :cities="cities" />
    </div>
</template>

<script setup>
import Cities from '@/Components/Cities/List.vue';

const props = defineProps({
  country: String,
  cities: Array,
});
</script>
