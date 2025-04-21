<template>
  <a href="/" class="absolute transform -translate-y-1/2 top-1/2 left-2 sm:flex hidden w-[44px] h-[44px]">
    <img :src="getImage('home.png')" class="invert">
  </a>
</template>

<script setup>
const getImage = (imagePath) => `${window.location.origin}/img/${imagePath}`;
</script>