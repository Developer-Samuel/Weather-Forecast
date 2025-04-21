<template>
    <div class="w-full h-auto px-4">
        <div class="flex justify-center sm:py-8 pt-12 pb-8">
            <p class="text-3xl font-bold text-center">
                Countries
            </p>
        </div>
        <Countries :countries="countries" />
    </div>
</template>

<script setup>
import { ref } from 'vue';
import Countries from '@/Components/Countries/List.vue';

const props = defineProps({
  countries: Array,
});

const countries = ref(props.countries || []);
</script>