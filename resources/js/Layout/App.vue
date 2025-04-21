<template>
    <Header />
    <div class="relative top-[50px] flex justify-center w-full min-h-screen h-full bg-gray-900 text-white py-4 transition duration-500">
        <img :src="getImage('home.png')" class="absolute left-2 w-[36px] h-auto sm:hidden flex invert">
        <slot></slot>
    </div>
</template>

<script setup>
import Header from '../Includes/Header.vue';

const getImage = (imagePath) => `${window.location.origin}/img/${imagePath}`;
</script>