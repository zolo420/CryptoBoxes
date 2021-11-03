<template>
  <main class="home">
    <kinesis-container>
      <div class="home__top">
        <div class="container">
          <div class="home__line">
            <div class="home__text">
              <div v-if="$breakpoints.width > 700" class="home__title">
                ROB & RUN
              </div>
              <div class="home__desc">
                Выбери бокс с криптовалютным кошельком Расставь слова seed-фразы
                на свои места И содержимое кошелька твоё!
              </div>
              <div class="home__btn">
                <Button large>Начать</Button>
              </div>
            </div>
            <div class="home__images">
              <div class="home__image">
                <kinesis-element
                  :strength="30"
                  type="translate"
                  tag="img"
                  src="/images/box-gray.svg"
                  class="img-responsive"
                />
              </div>

              <div v-if="$breakpoints.width <= 700" class="home__title">
                ROB & RUN
              </div>
              <!-- <FadeTransition>
                <div v-if="isVisible" class="home__box">
                  <box
                    :is-box="false"
                    :box="{ color: 'blue', currency: 'ethereum' }"
                    :is-small="$breakpoints.width <= 530"
                    :is-shadow="true"
                    :is-open="isVisible"
                  />
                </div>
              </FadeTransition> -->

              <div class="home__box">
                <box
                  :is-box="false"
                  :box="{ color: 'blue', currency: 'ethereum' }"
                  :is-small="$breakpoints.width <= 530"
                  :is-shadow="true"
                />
              </div>
              <div class="home__image">
                <kinesis-element
                  :strength="30"
                  type="translate"
                  tag="img"
                  src="/images/box-orange.svg"
                  class="img-responsive"
                />
              </div>
            </div>
          </div>
        </div>
      </div>
    </kinesis-container>
    <div class="home__boxes">
      <section id="hard" class="home__section">
        <div class="page__subtitle page__subtitle--orange">HARD BOXES</div>
        <div class="container">
          <carousel class-slide="home__slide" :props-array="hardBoxes">
            <template #card="{ item }">
              <box :box="item" type="hard"></box>
            </template>
          </carousel>
        </div>
      </section>

      <section id="easy" class="home__section">
        <div class="page__subtitle page__subtitle--gray page__subtitle--right">
          EASY BOXES
        </div>
        <div class="container">
          <carousel
            class-slide="home__slide"
            color-array="#B0B0B0"
            :props-array="easyBoxes"
          >
            <template #card="{ item }">
              <box :box="item" type="easy"></box>
            </template>
          </carousel>
        </div>
      </section>

      <section id="quest" class="home__section">
        <div class="page__subtitle page__subtitle--blue">QUEST BOXES</div>
        <div class="container">
          <carousel
            class-slide="home__slide"
            color-array="#4854AF"
            :props-array="questBoxes"
          >
            <template #card="{ item }">
              <box :box="item" type="quest"></box>
            </template>
          </carousel>
        </div>
      </section>
    </div>

    <infos></infos>
  </main>
</template>

<script>
// import { FadeTransition } from 'vue2-transitions'
import Box from '~/components/Box/Box'
import Button from '~/components/Button/Button'
import Carousel from '~/components/Carousel'
import Infos from '~/components/Infos/Infos'

export default {
  name: 'Home',
  components: {
    // FadeTransition,
    Box,
    Button,
    Infos,
    Carousel,
  },

  data() {
    return {
      hardBoxes: [],
      easyBoxes: [],
      questBoxes: [],
    }
  },
  head() {
    return {
      title: 'ROB & RUN',
    }
  },
  mounted() {
    this.$axios.get('/box-list').then((res) => {
      for (const box of res.data.items) {
        if (box.type === 'Easy-box') this.easyBoxes.push(box)
        else if (box.type === 'Hard-box') this.hardBoxes.push(box)
        else this.questBoxes.push(box)
      }
      console.log(this.easyBoxes, this.hardBoxes, this.questBoxes)
    })
  },
}
</script>

<style lang="scss">
.home {
  &__top {
    margin: 69px 0 140px;
    position: relative;

    @include rwd(700) {
      margin: 20px 0 100px;
    }

    &::before {
      content: '';
      position: absolute;
      width: 65%;
      right: 0;
      background-color: #f2f2f2;
      z-index: 50;
      height: 100%;

      @include rwd(700) {
        display: none;
      }
    }
  }

  &__line {
    display: flex;
    position: relative;
    z-index: 51;

    @include rwd(700) {
      flex-direction: column-reverse;
    }
  }

  &__text {
    // max-width: calc(100% - 500px);
    max-width: 55%;
    width: 100%;
    padding: 105px 0 75px;

    @include notebook {
      max-width: 50%;
    }
    @include desktop {
      max-width: 45%;
    }
    @include widescreen {
      max-width: 60%;
    }

    @include tablet {
      padding: 50px 0;
    }

    @include rwd(700) {
      padding: 0;
      max-width: 100%;
    }
  }

  &__title {
    font-weight: 900;
    font-size: 68px;
    line-height: 96px;
    letter-spacing: 0.14em;
    margin-bottom: 6px;

    @include desktop {
      font-size: 50px;
      line-height: 60px;
    }

    @include rwd(700) {
      max-width: 50%;
      width: 100%;
      background-color: $gray-100;
      padding: 100px 0 100px 15px;
      left: -15px;
      position: relative;
    }

    @include rwd(530) {
      padding: 50px 0 50px 15px;
      font-size: 45px;
      line-height: 109.52%;
    }

    @include rwd(360) {
      font-size: 40px;
      line-height: 109.52%;
    }
  }

  &__desc {
    font-family: $PTMono;
    font-size: 24px;
    line-height: 27px;
    color: #333333;
    padding-left: 40px;
    margin-bottom: 34px;
    position: relative;

    &::before {
      content: '';
      position: absolute;
      width: 12px;
      left: 0;
      top: 0;
      height: 100%;
      background: #fe4d17;
    }

    @include rwd(1100) {
      font-size: 20px;
      line-height: 24px;
    }

    @include rwd(700) {
      font-size: 18px;
      line-height: 20px;
      padding-left: 32px;
    }
  }

  &__btn {
    @include rwd(700) {
      text-align: center;
    }
  }

  &__section {
    padding-bottom: 175px;

    @include desktop {
      padding-bottom: 130px;
    }

    @include widescreen {
      padding-bottom: 100px;
    }
  }

  &__grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 45px;
  }

  &__images {
    position: relative;
    align-items: flex-start;
    justify-content: center;
    display: flex;
    // max-width: 500px;
    max-width: 45%;
    width: 100%;
    padding: 33px 0;
    right: -50px;

    @include notebook {
      right: 0;
      justify-content: center;
      max-width: 50%;
    }

    @include desktop {
      max-width: 55%;
    }

    @include widescreen {
      align-items: center;
      max-width: 40%;
    }

    @include rwd(700) {
      padding: 0;
      max-width: 100%;
      margin-bottom: 30px;
      justify-content: flex-start;
    }
  }

  &__image {
    position: absolute;
    z-index: 5;

    &::before {
      content: '';
      position: absolute;
      left: 50%;
      width: 301.09px;
      height: 130.66px;
      transform: translateX(-50%);
      bottom: -75px;
      z-index: -1;
      background-image: radial-gradient(
        58.16% 35.15% at 50% 58.55%,
        rgba(0, 0, 0, 0.15) 0%,
        rgba(60, 60, 60, 0) 74.48%
      );
    }

    &:first-child {
      // left: -10px;
      right: 350px;
      bottom: 100px;
      filter: drop-shadow(10px 10px 30px rgba(108, 115, 149, 0.15));

      &::before {
        width: 179px;
        height: 74px;
        bottom: -40px;
      }

      @include notebook {
        // left: 0;
        right: 380px;
        bottom: 130px;
      }

      @include desktop {
        bottom: 70px;
        right: 370px;
      }

      @include rwd(1100) {
        right: auto;
        left: 20px;
      }
    }

    &:last-child {
      right: -25px;
      bottom: 60px;
      filter: drop-shadow(10px 10px 30px rgba(250, 103, 58, 0.15));
      @include notebook {
        right: 0;
      }
      @include desktop {
        bottom: 50px;
      }
    }

    @include widescreen {
      display: none;
    }
  }

  &__box {
    filter: drop-shadow(10px 10px 30px rgba(50, 62, 149, 0.15));

    @include rwd(700) {
      max-width: 50%;
      width: 100%;
      margin-left: 30px;
    }

    @include rwd(530) {
      display: flex;
      justify-content: center;
      margin: 0;
    }
  }

  &__slide {
    &.swiper-slide {
      width: 245px;
      @include xmobile {
        width: 100%;
      }
    }

    .Box {
      &__cub {
        @include xmobile {
          margin: 0 auto 10px;
        }
      }
    }
  }
}
</style>
