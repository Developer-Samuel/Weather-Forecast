<template>
    <div class="flex justify-center mt-16">
        <button
            @click="downloadFile"
            class="text-xl font-bold bg-green-600 hover:bg-green-700 px-6 py-3 rounded-2xl transition-linear duration-500"
        >
            Download
        </button>
    </div>
</template>

<script setup>
const props = defineProps({
    country: String,
    city: String,
});

const downloadFile = () => {
    const url = `/api/weather/${props.country}/${props.city}/download`;
    const a = document.createElement('a');
    a.href = url;
    a.setAttribute('download', 'weather_forecast.xlsx');
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
};
</script>
