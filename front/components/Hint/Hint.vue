<template>
  <div v-if="hint" class="hint">
    <div class="hint__top">
      <div class="hint__title">
        <Icon v-if="hint.icon" :icon-name="hint.icon" fill="none" />
        {{ hint.name }}
      </div>
      <div class="hint__price">За {{ hint.price }}$</div>
    </div>
    <div class="hint__text" v-html="hint.text"></div>
    <div class="hint__btns">
      <Button
        :large="$breakpoints.width > 414"
        :small="$breakpoints.width < 375"
        class="hint__pay"
        :disabled="participants < hint.users_for_open"
        @click="$emit('pay-hint', hint)"
      >
        Купить
      </Button>
      <Button
        outline
        dark
        :disabled="participants < hint.users_for_open"
        :large="$breakpoints.width > 414"
        :small="$breakpoints.width < 375"
      >
        Пригласить друга
      </Button>
    </div>
  </div>
</template>

<script>
import Icon from '@/components/Icon/Icon'
import Button from '~/components/Button/Button'
export default {
  name: 'Hint',
  components: { Icon, Button },
  props: {
    hint: {
      type: Object,
      default: null,
    },
    participants: {
      type: Number,
      default: 0,
    },
  },
}
</script>

<style lang="scss">
.hint {
  background-color: $white;
  box-shadow: 10px 10px 30px rgba(0, 0, 0, 0.07);
  padding: 50px 70px;

  @include tablet {
    padding: 40px 25px;
  }
  &__top {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 22px;
    @include tablet {
      margin-bottom: 10px;
    }
  }

  &__title {
    font-size: 24px;
    line-height: 28px;
    letter-spacing: 0.14em;
    text-transform: uppercase;
    display: flex;
    align-items: center;
    svg {
      margin-right: 10px;
      min-width: 20px;
    }

    @include tablet {
      font-size: 20px;
      line-height: 22px;
    }

    @include mobile {
      font-size: 16px;
      line-height: 18px;
    }

    @include rwd(360) {
      font-size: 14px;
      line-height: 16px;
    }
  }
  &__price {
    font-weight: 900;
    font-size: 26px;
    line-height: 26px;
    white-space: nowrap;
    @include tablet {
      font-size: 22px;
      line-height: 22px;
      margin-left: 10px;
    }

    @include mobile {
      font-size: 16px;
      line-height: 16px;
    }
  }

  &__text {
    font-family: $PTMono;
    font-size: 20px;
    line-height: 22px;

    span {
      color: $red;
    }

    @include tablet {
      font-size: 18px;
      line-height: 20px;
    }

    @include mobile {
      font-size: 16px;
      line-height: 18px;
    }
  }

  &__btns {
    margin-top: 35px;
    display: flex;

    @include tablet {
      margin-top: 30px;
    }
  }

  &__pay {
    margin-right: 30px;

    @include mobile {
      margin-right: 15px;
    }
  }
}
</style>
