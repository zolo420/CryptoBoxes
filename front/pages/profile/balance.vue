<template>
  <div class="balance">
    <div class="balance__top">
      <div class="balance__tabs">
        <a
          href="#"
          class="balance__tab"
          :class="{ 'balance__tab--active': tabActive === 1 }"
          @click.prevent="tabActive = 1"
        >
          Криптовалюты
        </a>
        <a
          href="#"
          class="balance__tab"
          :class="{ 'balance__tab--active': tabActive === 2 }"
          @click.prevent="tabActive = 2"
        >
          История транзакциЙ
        </a>
      </div>
      <Button :fluid="$breakpoints.width <= 480">Пополнить</Button>
    </div>

    <transition name="slide-fade-down" class="balance__group" mode="out-in">
      <div v-if="tabActive === 1" :key="1" class="balance__list">
        <BalanceItem
          v-for="balance in balances"
          :key="balance.id"
          :balance="balance"
        />
      </div>

      <div v-if="tabActive === 2" :key="2" class="balance__list">
        <div class="balance__counts">
          <div
            v-for="balance in balances"
            :key="balance.id"
            class="balance__count"
          >
            {{ balance.balance }}
            <icon :icon-name="balance.cryptocurrency" />
          </div>
        </div>
        <balance-history
          v-for="history in histories"
          :key="history.id"
          :history="history"
        />
      </div>
    </transition>
  </div>
</template>

<script>
import Button from '@/components/Button'
import BalanceHistory from '~/components/Balance/BalanceHistory.vue'
import BalanceItem from '~/components/Balance/BalanceItem.vue'
export default {
  name: 'Balance',
  components: { Button, BalanceHistory, BalanceItem },
  layout: 'profile',
  data() {
    return {
      tabActive: 1,
      balances: [],
      histories: [],
    }
  },

  head() {
    return {
      title: 'Профиле | Мой счет',
    }
  },
  mounted() {
    this.$axios.get('/profile/wallets').then((res) => {
      this.balances = res.data.items
    })
    this.$axios.get('/profile/transaction-history').then((res) => {
      this.histories = res.data.items
    })
  },
}
</script>

<style lang="scss">
.balance {
  padding: 30px 70px 50px;
  @include widescreen {
    padding: 30px 15px;
  }

  @include tablet {
    padding: 30px 0;
  }

  &__top {
    display: flex;
    align-items: center;
    justify-content: space-between;

    @include xmobile {
      flex-direction: column-reverse;
      align-items: flex-start;
    }
  }

  &__tabs {
    display: flex;
    @include xmobile {
      margin-top: 30px;
      justify-content: center;
      width: 100%;
    }
  }
  &__tab {
    font-weight: bold;
    font-size: 14px;
    line-height: 16px;
    letter-spacing: 0.14em;
    text-transform: uppercase;
    color: #000000;
    transition: all 0.5s ease;
    margin-left: 35px;

    @include widescreen {
      margin-left: 15px;
      font-size: 12px;
      line-height: 14px;
    }

    @include xmobile {
      font-size: 11px;
    }

    &:first-child {
      margin: 0;
    }
    &:hover,
    &--active {
      color: $red;
    }
  }

  &__list {
    margin-top: 30px;
  }

  &__counts {
    display: flex;
    margin-bottom: 17px;
  }

  &__count {
    padding: 12px 45px;
    background-color: $white;
    box-shadow: 10px 10px 30px rgba(0, 0, 0, 0.07);
    font-weight: 900;
    font-size: 20px;
    line-height: 28px;
    display: flex;
    align-items: center;
    justify-content: center;
    &:first-child {
      margin-right: 30px;
      @include xmobile {
        margin-right: 15px;
      }
    }

    @include xmobile {
      width: 100%;
      font-size: 18px;
      line-height: 1;
      padding: 15px;
    }
  }
}
</style>
