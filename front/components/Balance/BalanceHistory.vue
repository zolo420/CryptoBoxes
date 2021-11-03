<template>
  <div v-if="history" class="BalanceHistory">
    <div class="BalanceHistory__top">
      <div class="BalanceHistory__name">{{ history.direction.name }}</div>
      <div
        class="BalanceHistory__count"
        :style="{ color: history.direction.color }"
      >
        <div v-if="history.direction.operator" class="BalanceHistory__operator">
          {{ history.direction.operator }}
        </div>
        {{ history.value }}
        <icon :icon-name="history.currency" />
      </div>
    </div>
    <div class="BalanceHistory__date">{{ history.date_time }}</div>
  </div>
</template>

<script>
import Icon from '../Icon/Icon.vue'
export default {
  name: 'BalanceHistory',
  components: { Icon },
  props: {
    history: {
      type: Object,
      default: null,
      require: true,
    },
  },
}
</script>

<style lang="scss">
.BalanceHistory {
  background-color: $white;
  box-shadow: 10px 10px 30px rgba(0, 0, 0, 0.07);
  margin-bottom: 10px;
  padding: 32px 30px;

  @include xmobile {
    padding: 40px 25px;
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

    @include xmobile {
      font-size: 18px;
      line-height: 21px;
      letter-spacing: 1px;
    }
  }
  &__date {
    margin-top: 10px;
    font-family: $PTMono;
    font-size: 14px;
    line-height: 16px;
    letter-spacing: 0.14em;
    color: #b0b0b0;
  }

  &__count {
    font-weight: 900;
    font-size: 20px;
    line-height: 28px;
    display: flex;
    align-items: center;

    @include xmobile {
      font-size: 18px;
      line-height: 21px;
    }
  }

  &__operator {
    color: #000;
    margin-right: 5px;
  }
}
</style>
