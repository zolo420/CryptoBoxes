<template>
  <div class="history">
    <div class="history__title">Ваша история кейсов</div>

    <div class="history__list">
      <HistoryItem v-for="item in cases" :key="item.id" :case-prop="item" />
    </div>
  </div>
</template>

<script>
import HistoryItem from '~/components/History/HistoryItem.vue'
export default {
  name: 'History',
  components: { HistoryItem },
  layout: 'profile',

  data() {
    return {
      cases: [],
    }
  },

  head() {
    return {
      title: 'Профиле | История открытых кейсов',
    }
  },
  mounted() {
    this.$axios.get('/profile/box-payment-history').then((res) => {
      this.cases = res.data.items
    })
  },
}
</script>

<style lang="scss">
.history {
  padding: 50px 70px;
  @include widescreen {
    padding: 30px 15px;
  }

  @include tablet {
    padding: 30px 0;
  }

  &__title {
    font-weight: bold;
    font-size: 14px;
    line-height: 16px;
    letter-spacing: 0.14em;
    text-transform: uppercase;
    color: $red;
    margin-bottom: 30px;
  }
}
</style>
