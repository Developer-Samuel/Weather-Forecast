<template>
    <div v-if="days.length" class="w-full relative">
      <swiper
        :modules="[Navigation]"
        :space-between="10"
        :breakpoints="getBreakpoints()"
        :slides-per-group="1"
        navigation
        @swiper="onSwiperInit"
        class="rounded-xl overflow-hidden"
      >
        <swiper-slide v-for="(day, index) in days" :key="index">
          <a
            :href="`/weather/${country}/${formattedCity}?date=${formatDate(day.date)}`"
            :class="{
              'relative flex flex-col justify-between items-center border-[3px] border-solid rounded-xl w-full h-auto px-4 py-8': true,
              'bg-black border-blue-600': isActiveDate(day.date),
              'bg-white border-white': !isActiveDate(day.date)
            }"
          >
            <p
              :class="{
                'text-lg font-semibold': true,
                'text-white': isActiveDate(day.date),
                'text-black': !isActiveDate(day.date)
              }"
            >
              {{ day.label }}
            </p>
            <p
              :class="{
                'text-sm': true,
                'text-gray-400': isActiveDate(day.date),
                'text-gray-700': !isActiveDate(day.date)
                }
            ">
              {{ formatDate(day.date) }}
            </p>
          </a>
        </swiper-slide>
      </swiper>
    </div>
  </template>

<script setup>
import { ref, computed, nextTick } from 'vue';
import { Swiper, SwiperSlide } from 'swiper/vue';
import { Navigation } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/navigation';

const props = defineProps({
    days: Array,
    country: String,
    city: String,
});

const swiperInstance = ref(null);

const formattedCity = computed(() => props.city.replaceAll(' ', '-'));

const getCurrentDateParam = () => {
    const currentUrl = new URL(window.location.href);
    return currentUrl.searchParams.get('date');
}

const formatDate = (dateString) => {
    const date = new Date(dateString);
    const day = date.getDate();
    const month = date.getMonth() + 1;
    const year = date.getFullYear();
    return `${day}.${month}.${year}`;
}

const isActiveDate = (dayDate) => {
    const currentDate = getCurrentDateParam();
    if (!currentDate) {
      return props.days.length && props.days[0].date === dayDate;
    }
    return currentDate === formatDate(dayDate);
};

const onSwiperInit = (swiper) => {
    swiperInstance.value = swiper;

    nextTick(() => {
      const currentDate = getCurrentDateParam();
      const targetIndex = props.days.findIndex(day => formatDate(day.date) === currentDate);
      if (targetIndex !== -1) {
        swiper.slideTo(targetIndex);
      }
    });
};

const getBreakpoints = () => {
    return {
        1024: { slidesPerView: 4 },
        768: { slidesPerView: 3 },
        640: { slidesPerView: 2 },
        0: { slidesPerView: 1 }
    }
};
</script>

<style scoped>
::v-deep(.swiper-button-prev) {
    left: 0;
}
::v-deep(.swiper-button-next) {
    right: 0;
}
::v-deep(.swiper-button-next),
::v-deep(.swiper-button-prev) {
  top: 22px;
  width: 35px;
  height: 100%;
  color: white;
  background: rgba(0, 0, 0, 0.5);
}

::v-deep(.swiper-button-next::after),
::v-deep(.swiper-button-prev::after) {
  font-size: 24px;
}
</style>
