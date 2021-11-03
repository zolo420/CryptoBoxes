<template>
  <div v-if="balance" class="BalanceItem">
    <div class="BalanceItem__left">
      <div class="BalanceItem__name">{{ balance.name }}</div>
      <div class="BalanceItem__number">
        <span :style="{ color: balance.color }">№</span>
        {{ balance.address }}
      </div>
    </div>
    <div class="BalanceItem__right">
      <div
        class="BalanceItem__count"
        :style="{
          color: balance.cryptocurrency === 'bitcoin' ? '#FE4D17' : '#4854AF',
        }"
      >
        <span>Остаток</span>
        {{ balance.balance }}
        <icon
          v-if="balance.cryptocurrency"
          :icon-name="balance.cryptocurrency"
        />
      </div>
      <Button dark outline :medium="$breakpoints.width > 576">Вывести</Button>
    </div>
  </div>
</template>

<script>
import Button from '../Button/Button.vue'
import Icon from '../Icon/Icon.vue'
export default {
  name: 'BalanceItem',
  components: { Icon, Button },
  props: {
    balance: {
      type: Object,
      default: null,
      require: true,
    },
  },
}
</script>

<style lang="scss">
.BalanceItem {
  background-color: $white;
  box-shadow: 10px 10px 30px rgba(0, 0, 0, 0.07);
  margin-bottom: 10px;
  padding: 32px 30px;
  display: flex;
  justify-content: space-between;

  @include tablet {
    padding: 40px 25px;
  }

  @include mobile {
    flex-direction: column;
  }

  @include rwd(360) {
    padding: 30px 15px;
  }

  &__top {
    display: flex;
    align-items: center;
    justify-content: space-between;
  }
  &__name {
    font-weight: bold;
    font-size: 20px;
    line-height: 23px;
    letter-spacing: 0.14em;

    @include rwd(360) {
      font-size: 18px;
      line-height: 20px;
    }
  }
  &__number {
    font-family: $PTMono;
    font-size: 20px;
    line-height: 22px;
    text-align: center;
    letter-spacing: 0.14em;
    color: #b0b0b0;
    display: flex;
    margin-top: 10px;

    @include mobile {
      font-size: 18px;
      line-height: 20px;
    }

    @include rwd(360) {
      font-size: 16px;
      line-height: 18px;
    }
  }

  &__count {
    font-weight: 900;
    font-size: 20px;
    line-height: 28px;
    display: flex;
    align-items: center;
    margin-bottom: 10px;

    span {
      color: $black;
      margin-right: 10px;
    }

    @include mobile {
      font-size: 18px;
      line-height: 25px;
    }

    @include rwd(360) {
      font-size: 16px;
      line-height: 18px;
    }
  }

  &__right {
    display: flex;
    flex-direction: column;
    align-items: flex-end;

    @include mobile {
      flex-direction: row;
      justify-content: space-between;
      margin-top: 20px;
    }
  }
}
</style>
