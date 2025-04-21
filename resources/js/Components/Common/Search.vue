<template>
    <div class="flex sm:w-[500px] rounded-xl w-full overflow-hidden">
        <input
            v-model="queryInput"
            @keyup.enter="submitSearch"
            type="text"
            name="search"
            id="search"
            placeholder="Search..."
            class="text-lg font-semibold placeholder:text-sm placeholder:font-medium w-full px-3 py-1 border-0 outline-0"
        />
        <button
            @click="submitSearch"
            class="bg-blue-600 hover:bg-blue-700 px-3 py-1 transition-all duration-500 text-white "
        >
            <img :src="getImage('search.png')" class="w-[24px] invert">
        </button>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';

const queryInput = ref('');

onMounted(() => {
    const url = new URL(window.location.href);
    const query = url.searchParams.get('query');
    if (query) {
        queryInput.value = query;
    }
})

const getImage = (imagePath) => `${window.location.origin}/img/${imagePath}`;

const submitSearch = () => {
    if (queryInput.value.trim()) {
        window.location.href = `/search/find?query=${encodeURIComponent(queryInput.value)}`;
    }
};
</script>
