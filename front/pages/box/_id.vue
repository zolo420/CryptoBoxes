<template>
  <main class="product">
    <div class="product__top">
      <div class="container">
        <div class="product__line">
          <div class="product__text">
            <div v-if="$breakpoints.width > 576" class="product__price">
              {{ bank }}
              <Icon
                icon-name="bitcoin"
                :width="$breakpoints.width <= 768 ? 18 : 34"
                :height="$breakpoints.width <= 768 ? 28 : 50"
              />
            </div>
            <div class="product__desc">
              <div class="product__currency">Bitcoin</div>
              <div class="product__number">
                <span>№ </span>
                {{ address }}
              </div>
              <div class="product__type">HARD BOXES</div>
              <div class="product__count">
                Количество участников
                <strong>{{ participants }}</strong>
              </div>
            </div>
          </div>
          <div class="product__box">
            <box
              :is-box="false"
              :box="{ color: 'orange', currency: 'ethereum' }"
              :is-small="$breakpoints.width < 576"
            />

            <div v-if="$breakpoints.width <= 576" class="product__price">
              0,394
              <Icon
                icon-name="bitcoin"
                :width="$breakpoints.width <= 768 ? 18 : 34"
                :height="$breakpoints.width <= 768 ? 28 : 50"
              />
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="container">
      <div class="product__subtitle product__subtitle--small">
        Расставь слова seed-фразы в правильном порядке, просто перетащив их на
        свои места, и нажмите на кнопку «Результат»
      </div>
    </div>

    <div class="product__counts">Попытка <strong>1 из 15</strong></div>

    <div class="container">
      <div class="product__wrap">
        <div class="product__block">
          <div class="product__dragdrop product__dragdrop--back">
            <div v-for="i in words.length" :key="i" class="product__item">
              {{ i }}
            </div>
          </div>
          <draggable class="product__dragdrop" :list="newWords" group="words">
            <div
              v-for="el in newWords"
              :key="el.id"
              class="product__item product__item--blue"
            >
              {{ el.title }}
            </div>
          </draggable>
        </div>
        <draggable
          v-if="words && words.length"
          :list="words"
          group="words"
          class="product__dragdrop product__dragdrop--two"
        >
          <div
            v-for="word in words"
            :key="word.id"
            class="product__item product__item--blue"
          >
            {{ word.title }}
          </div>
        </draggable>
        <div class="product__btn">
          <Button
            :small="$breakpoints.width <= 768"
            :large="$breakpoints.width > 768"
            :disabled="words.length !== 0"
            @click="makeAttempt"
          >
            Узнать результат
          </Button>
          <Button
            class="product__friend"
            :large="$breakpoints.width > 768"
            :small="$breakpoints.width <= 768"
            outline
            dark
            @click="openModal"
          >
            Пригласить друга
          </Button>
        </div>
      </div>
    </div>

    <section class="product__section">
      <div class="container">
        <div class="page__subtitle page__subtitle--ttu product__subtitle">
          Купить подсказки!
        </div>

        <Hint
          v-for="hint in hints"
          :key="hint.id"
          :hint="hint"
          :participants="participants"
          class="product__hint"
          @pay-hint="payHint"
        />
      </div>
    </section>
  </main>
</template>

<script>
import draggable from 'vuedraggable'
import Box from '~/components/Box'
import Hint from '~/components/Hint'
import Button from '~/components/Button'
export default {
  name: 'Product',
  components: {
    Box,
    Button,
    Hint,
    draggable,
  },
  data() {
    return {
      countStart: 1,
      countMax: 15,
      newWords: [],
      words: [],
      bank: 0,
      address: '',
      participants: 0,
      hints: [],
    }
  },
  mounted() {
    this.$axios.get('/box-info/' + this.$route.params.id).then((res) => {
      for (const ix in res.data.seed)
        this.words.push({ id: ix, title: res.data.seed[ix] })
      this.bank = res.data.bank
      this.address = res.data.address
      this.hints = res.data.hints
      this.participants = res.data.participants
    })
  },
  methods: {
    payHint(hint) {
      // eslint-disable-next-line no-console
      console.log(hint)
      this.$axios
        .post(`/profile/buy-hint/${this.$route.params.id}/${hint.id}`)
        .then(() => {
          location.reload()
        })
        .catch(() => {
          console.log('hint error')
        })
    },
    openModal() {
      this.$store.commit('modals/SET_MODAL', {
        name: 'invite',
      })
    },
    makeAttempt() {
      this.$axios
        .post('/profile/buy-box', {
          box_id: this.$route.params.id,
          seed: this.newWords,
        })
        .then((res) => {
          console.log(res.data)
        })
        .catch((err) => {
          console.log(err.toJSON())
        })
    },
  },
}
</script>

<style lang="scss">
.product {
  &__top {
    margin: 69px 0 105px;
    position: relative;

    &::before {
      content: '';
      position: absolute;
      width: 49%;
      right: 0;
      background-color: #f2f2f2;
      z-index: 50;
      height: 100%;

      @include tablet {
        width: 52%;
      }

      @include mobile {
        display: none;
      }
    }

    @include widescreen {
      margin: 20px 0 70px;
    }
  }

  &__line {
    display: flex;
    position: relative;
    z-index: 51;

    @include tablet {
      align-items: center;
    }

    @include mobile {
      flex-direction: column-reverse;
    }
  }

  &__text {
    max-width: 50%;
    width: 100%;
    padding-right: 30px;

    @include mobile {
      padding: 0;
      max-width: 100%;
    }
  }

  &__box {
    max-width: 50%;
    width: 100%;
    margin: 0 90px 0 auto;
    padding: 50px 0;
    display: flex;
    align-items: center;
    justify-content: flex-end;

    @include tablet {
      margin: 0;
      align-self: center;
      justify-content: center;
    }

    @include mobile {
      max-width: 100%;
      margin-bottom: 24px;
      padding: 0;
      justify-content: space-between;
      position: relative;
    }

    &::before {
      content: '';
      position: absolute;
      width: calc(100% - 135px);
      top: 0;
      right: -15px;
      background-color: #f2f2f2;
      z-index: 50;
      height: 100%;
      display: none;
      z-index: -1;
      @include mobile {
        display: block;
      }

      @include rwd(360) {
        justify-content: flex-end;
        width: calc(100% - 120px);
      }
    }
  }

  &__price {
    font-weight: 900;
    font-size: 64px;
    line-height: 1;
    margin-bottom: 35px;
    display: flex;
    align-items: center;

    svg {
      margin-left: 20px;

      @include mobile {
        margin-left: 5px;
      }
    }

    @include widescreen {
      font-size: 50px;
    }

    @include tablet {
      font-size: 30px;
    }

    @include mobile {
      justify-content: center;
      width: calc(100% - 140px);
      margin: 0;
    }

    @include rwd(360) {
      justify-content: flex-end;
      width: calc(100% - 120px);
    }
  }

  &__desc {
    position: relative;
    padding-left: 40px;
    &::before {
      content: '';
      position: absolute;
      width: 12px;
      height: 111px;
      left: 0;
      top: 0;
      height: 100%;
      background: #fe4d17;
    }

    @include tablet {
      padding-left: 32px;
    }
  }

  &__currency {
    margin-bottom: 10px;
    font-weight: bold;
    font-size: 26px;
    line-height: 30px;
    letter-spacing: 0.14em;

    @include tablet {
      font-size: 22px;
      line-height: 1;
    }

    @include mobile {
      font-size: 18px;
    }
  }

  &__number {
    font-family: $PTMono;
    font-size: 26px;
    line-height: 29px;
    letter-spacing: 0;
    color: #b0b0b0;
    span {
      color: #000000;
    }

    @include tablet {
      font-size: 22px;
      line-height: 1;
    }

    @include mobile {
      font-size: 18px;
    }
  }

  &__type {
    margin-top: 40px;
    font-weight: bold;
    font-size: 26px;
    line-height: 30px;
    letter-spacing: 0.14em;
    text-transform: uppercase;

    @include tablet {
      font-size: 22px;
      line-height: 1;
      margin-top: 20px;
    }

    @include mobile {
      font-size: 18px;
    }
  }

  &__count {
    font-family: $PTMono;
    font-size: 26px;
    line-height: 29px;
    color: #b0b0b0;
    margin-top: 6px;

    @include tablet {
      font-size: 22px;
      line-height: 1;
    }

    @include mobile {
      font-size: 18px;
    }

    strong {
      font-family: 'Arial';
      font-style: normal;
      font-weight: 900;
      font-size: 26px;
      line-height: 1;
      letter-spacing: 0.02em;
      color: #000000;

      @include tablet {
        font-size: 22px;
        line-height: 1;
      }

      @include mobile {
        font-size: 18px;
      }
    }
  }

  &__wrap {
    padding-bottom: 140px;

    @include widescreen {
      padding-bottom: 70px;
    }
  }

  &__section {
    background: $gray-100;
    padding: 140px 0;

    @include widescreen {
      padding: 70px 0 100px;
    }
  }

  &__hint {
    margin-bottom: 30px;
    &:last-child {
      margin: 0;
    }
  }

  &__btn {
    display: flex;
    align-items: center;
    justify-content: center;
    margin-top: 60px;

    @include tablet {
      margin-top: 40px;
    }
  }

  &__subtitle {
    padding: 0;
    font-weight: bold;
    font-size: 24px;
    line-height: 28px;
    text-align: center;
    letter-spacing: 0.14em;
    text-transform: uppercase;
    margin-bottom: 40px;

    @include tablet {
      margin-bottom: 30px;
    }

    &--small {
      @include widescreen {
        font-size: 20px;
        line-height: 24px;
      }
      @include tablet {
        font-size: 18px;
        line-height: 22px;
      }

      @include mobile {
        font-size: 16px;
        line-height: 18px;
      }
      @include rwd(360) {
        font-size: 13px;
        line-height: 15px;
      }
    }
  }

  &__friend {
    margin-left: 30px;
    @include tablet {
      margin-left: 15px;
    }
  }

  &__counts {
    align-items: center;
    display: inline-flex;
    padding-left: calc((100% - 1110px) / 2);
    position: relative;
    padding-bottom: 10px;
    margin-bottom: 45px;

    font-family: $PTMono;
    font-size: 26px;
    line-height: 29px;

    strong {
      font-weight: 900;
      margin-left: 13px;
    }
    &::before {
      content: '';
      position: absolute;
      left: 0;
      height: 3px;
      width: 100%;
      bottom: 0;
      background-color: $red;
      @include widescreen {
        width: 50%;
      }
    }

    @include rwd(1140) {
      padding-left: 15px;
    }

    @include widescreen {
      justify-content: center;
      display: flex;
    }

    @include xmobile {
      font-size: 22px;
      line-height: 25px;
    }
  }

  &__block {
    position: relative;
    min-height: 174px;
    width: 100%;
    height: 100%;
  }

  &__dragdrop {
    display: grid;
    grid-template-columns: repeat(6, 1fr);
    gap: 70px 30px;
    min-width: 100%;
    min-height: 100%;

    @include widescreen {
      grid-template-columns: repeat(4, 1fr);
      gap: 30px;
    }

    @include tablet {
      gap: 15px;
    }
    @include rwd(360) {
      gap: 10px;
    }

    &--back {
      position: absolute;
      width: 100%;
      height: 100%;
      z-index: -1;
    }

    &--two {
      margin-top: 70px;
      gap: 30px;

      @include widescreen {
        margin-top: 40px;
      }
      @include tablet {
        gap: 15px;
      }
      @include rwd(360) {
        gap: 10px;
      }
    }
  }

  &__item {
    display: flex;
    justify-content: center;
    min-height: 52px;
    border-bottom: 3px solid #b0b0b0;

    font-family: $PTMono;
    font-size: 26px;
    line-height: 1;
    letter-spacing: 0.14em;
    color: #b0b0b0;

    @include tablet {
      align-items: center;
      font-size: 16px;
    }

    &--blue {
      min-height: 42px;
      align-items: center;
      border: none;
      color: $white;
      background-color: #4854af;
      font-size: 16px;
      line-height: 18px;
      font-family: 'Arial';
      cursor: move;
      @include tablet {
        font-size: 12px;
      }

      @include rwd(360) {
        font-size: 10px;
      }
    }
  }
}
</style>
