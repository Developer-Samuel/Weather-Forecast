<template>
    <div class="flex flex-col lg:w-[925px] w-full w-full h-screen sm:p-16 px-2 py-16">
        <Days :days="days" :country="country" :city="city" />
        <Times :times="times" :country="country" :city="city" />

        <Data
            :icon="icon"
            :description="description"
            :temperature="temperature"
            :country="country"
            :city="city"
            :date="date"
            :time="time"
        />

        <Button :country="country" :city="city" />
    </div>
</template>

<script setup>
import Days from '@/Components/Weather/Days.vue';
import Times from '@/Components/Weather/Times.vue';
import Data from '@/Components/Weather/Data.vue';
import Button from '@/Components/Weather/Button.vue';
import { toRefs } from 'vue';

const props = defineProps({
    icon: String,
    description: String,
    temperature: Number,
    country: String,
    city: String,
    date: String,
    time: String,
    days: Array,
    times: Array,
});

const { icon, description, temperature, country, city, date, time } = toRefs(props);
</script>
