<template>
    <div v-if="results.length">
        <div class="flex justify-center py-8">
            <p class="text-3xl font-bold text-center px-4">
                Results for "{{ query }}" ({{ results.length }})
            </p>
        </div>
        <div class="flex flex-col gap-4 bg-white border-b-2 border-solid border-black p-4">
            <Item v-for="(item, index) in results" :key="index" :item="item" />
        </div>
    </div>
    <div v-else class="absolute transform -translate-x-1/2 -translate-y-1/2 left-1/2 top-1/2">
        <p class="text-3xl font-bold text-white">No results found for "{{ query }}".</p>
    </div>
</template>

<script>
import Item from '@/Components/Search/Item.vue';

export default {
  components: { Item },
  props: {
    results: Array,
    query: String,
  },
  data() {
    return {
      queryInput: this.query || '',
    };
  },
};
</script>