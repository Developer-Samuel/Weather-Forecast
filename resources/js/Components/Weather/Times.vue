<template>
    <div v-if="times.length" class="w-full mt-16 relative">
      <swiper
        :modules="[Navigation]"
        :space-between="10"
        :breakpoints="getBreakpoints()"
        :slides-per-group="1"
        navigation
        class="rounded-xl overflow-hidden"
      >
        <swiper-slide v-for="(item, index) in times" :key="index">
          <a
            :href="generateTimeLink(item.time)"
            :class="{
              'relative flex flex-col justify-between items-center border-[3px] border-solid rounded-xl w-full px-4 py-2': true,
              'bg-black border-blue-600': isActiveTime(item.time),
              'bg-white border-white': !isActiveTime(item.time)
            }"
          >
            <p
              :class="{
                'text-lg font-semibold': true,
                'text-white': isActiveTime(item.time),
                'text-black': !isActiveTime(item.time)
              }"
            >
              {{ formatTime(item.time) }}
            </p>
          </a>
        </swiper-slide>
      </swiper>
    </div>
</template>

<script setup>
import { computed } from 'vue';
import { Swiper, SwiperSlide } from 'swiper/vue';
import { Navigation } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/navigation';

const props = defineProps({
  times: Array,
  country: String,
  city: String,
});

const formattedCity = computed(() => props.city.replaceAll(' ', '-'));

const formatTime = (time) => {
  const [hours, minutes] = time.split(':');
  return `${hours}:${minutes}`;
};

const generateTimeLink = (time) => {
  const currentUrl = new URL(window.location.href);
  let date = currentUrl.searchParams.get('date');

  if (!date) {
    const today = new Date();
    date = `${today.getDate()}.${today.getMonth() + 1}.${today.getFullYear()}`;
  }

  const cleanTime = time.replaceAll(':', '-');
  return `/weather/${props.country}/${formattedCity.value}?date=${date}&time=${cleanTime}`;
}

const isActiveTime = (time) => {
  const currentUrl = new URL(window.location.href);
  const currentTime = currentUrl.searchParams.get('time');

  if (!currentTime) {
    return props.times.length && props.times[0].time === time;
  }

  const formattedCurrentTime = currentTime.replaceAll('-', ':');
  return formattedCurrentTime === time;
};

const getBreakpoints = () => {
    return {
        1024: { slidesPerView: 6 },
        768: { slidesPerView: 4 },
        640: { slidesPerView: 3 },
        480: { slidesPerView: 2 },
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
  width: 25px;
  height: 100%;
  color: white;
  background: rgba(0, 0, 0, 0.5);
}

::v-deep(.swiper-button-next::after),
::v-deep(.swiper-button-prev::after) {
  font-size: 18px;
}
</style>
