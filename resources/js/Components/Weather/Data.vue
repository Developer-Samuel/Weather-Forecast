<template>
    <div class="response w-full mt-16">
        <div class="flex flex-col items-center gap-4">
            <div class="date text-lg">{{ formatDate(date) }}</div>
            <div class="date text-lg">{{ formatTime(time) }}</div>
            <div class="icon w-auto h-auto">
                <img :src="image">
            </div>
            <div class="text-2xl font-bold capitalize">{{ description }}</div>
            <div class="text-4xl font-bold">{{ temperature }} °C</div>
            <div class="country text-xl capitalize"><b>Country:</b> {{ country }}</div>
            <div class="city text-xl capitalize"><b>City:</b> {{ city }}</div>
        </div>
    </div>
</template>

<script setup>
import { toRefs, computed } from 'vue';

const props = defineProps({
    icon: String,
    description: String,
    temperature: Number,
    country: String,
    city: String,
    date: String,
    time: String,
});

const { icon, description, temperature, country, city, date, time } = toRefs(props);

const image = computed(() => `https://openweathermap.org/img/wn/${icon.value}@2x.png`);

const formatDate = (dateString) => {
    const date = new Date(dateString);
    const day = date.getDate();
    const month = date.getMonth() + 1;
    const year = date.getFullYear();
    return `${day}.${month}.${year}`;
};

const formatTime = (time) => {
    const [hours, minutes] = time.split(':');
    return `${hours}:${minutes}`;
};
</script>
