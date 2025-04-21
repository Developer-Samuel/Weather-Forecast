<template>
    <div class="fixed w-full h-[60px] bg-black z-[999]">
        <Logo />
        <div class="flex justify-center items-center h-full px-2">
            <Search />
        </div>
    </div>
</template>

<script>
import Logo from '@/Components/Common/Logo.vue';
import Search from '@/Components/Common/Search.vue';

export default {
  components: {
    Logo,
    Search,
  },
};
</script>
