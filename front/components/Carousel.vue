<template>
  <div v-if="propsArray" class="carousel">
    <div class="swiper-wrapper">
      <div
        v-for="(item, i) in propsArray"
        :key="i"
        class="swiper-slide"
        :class="classSlide"
      >
        <slot name="card" :item="item" />
      </div>
    </div>
    <button slot="button-prev" type="button" class="carousel__prev">
      <svg
        width="21"
        height="36"
        viewBox="0 0 21 36"
        fill="none"
        xmlns="http://www.w3.org/2000/svg"
      >
        <path d="M19 2L3 18L19 34" :stroke="colorArray" stroke-width="3" />
      </svg>
    </button>
    <button slot="button-next" type="button" class="carousel__next">
      <svg
        width="21"
        height="36"
        viewBox="0 0 21 36"
        fill="none"
        xmlns="http://www.w3.org/2000/svg"
      >
        <path d="M2 2L18 18L2 34" :stroke="colorArray" stroke-width="3" />
      </svg>
    </button>
  </div>
</template>

<script>
import SwiperInstance, { Navigation, Pagination, A11y } from 'swiper'

import 'swiper/swiper.scss'

SwiperInstance.use([Navigation, Pagination, A11y])
export default {
  name: 'Carousel',
  props: {
    propsArray: {
      type: Array,
      default: null,
    },
    classSlide: {
      type: String,
      default: '',
    },

    colorArray: {
      type: String,
      default: '#FE4D17',
    },
  },
  data() {
    return {
      swiperInstance: {},
      SwiperOptions: {
        slidesPerView: 'auto',
        spaceBetween: 40,
        navigation: {
          nextEl: '.carousel__next',
          prevEl: '.carousel__prev',
        },
      },
    }
  },

  mounted() {
    this.swiperInstance = new SwiperInstance(`.carousel`, this.SwiperOptions)
  },
}
</script>

<style lang="scss">
.carousel {
  position: relative;
  &__prev,
  &__next {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    padding: 0;
    z-index: 50;

    display: none;

    @include xmobile {
      display: block;
    }
  }

  &__prev {
    left: 0;
  }
  &__next {
    right: 0;
  }
}
</style>
