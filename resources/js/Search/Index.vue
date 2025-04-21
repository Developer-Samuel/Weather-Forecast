<template>
    <div class="top-[60px] w-full">
        <List :results="results" :query="query" />
    </div>
  </template>

<script>
import List from '@/Components/Search/List.vue';
export default {
  components: { List },
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
