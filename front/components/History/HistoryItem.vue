<template>
  <div v-if="caseProp" class="history__item">
    <div class="history__top">
      <div class="history__el">
        <div class="history__id">
          <img :src="`/images/case-${caseProp.currency.icon}.svg`" alt="" />
          ID {{ caseProp.caseId }}
        </div>
        <div class="history__date">{{ caseProp.dateTime }}</div>
      </div>
      <div class="history__el">
        <div class="history__payoff">
          Возможный выигрыш
          <span :style="{ color: caseProp.currency.color }">{{
            caseProp.box.starting_bank
          }}</span>
          <Icon :icon-name="caseProp.currency.icon" />
        </div>
        <div class="history__statuses">
          <div
            class="history__status"
            :style="{ color: caseProp.win ? caseProp.currency.color : null }"
          >
            Выиграл
          </div>
          <div
            class="history__status"
            :style="{ color: !caseProp.win ? caseProp.currency.color : null }"
          >
            Проиграл
          </div>
        </div>
      </div>
    </div>
    <div class="history__bottom">
      <div class="history__words">
        <div
          v-for="(seed, ix) in caseProp.seed"
          :key="ix"
          class="history__word"
        >
          {{ seed }}
        </div>
      </div>
      <div class="history__price">
        Стоимость участия
        <span :style="{ color: caseProp.currency.color }">
          {{ caseProp.price }}
        </span>
        $
      </div>
    </div>
  </div>
</template>

<script>
import Icon from '../Icon/Icon.vue'
export default {
  name: 'HistoryItem',
  components: { Icon },
  props: {
    caseProp: {
      type: Object,
      default: null,
      require: true,
    },
  },
}
</script>

<style lang="scss">
.history {
  $self: &;
  &__item {
    background-color: $white;
    box-shadow: 10px 10px 30px rgba(0, 0, 0, 0.07);
    margin-bottom: 10px;
    padding: 30px;

    @include widescreen {
      padding: 30px 15px;
    }

    @include mobile {
      padding: 30px 15px;
    }
  }

  &__top,
  &__bottom {
    display: flex;
    justify-content: space-between;

    @include mobile {
      flex-direction: column;
      width: 100%;
    }
  }

  &__top {
    #{$self} {
      &__el {
        &:first-child {
          @include mobile {
            display: flex;
            align-items: center;
            justify-content: space-between;
          }
        }
      }
    }
  }

  &__bottom {
    margin-top: 20px;
    align-items: flex-end;

    @include mobile {
      margin-top: 30px;
      align-items: center;
    }
  }

  &__id {
    font-weight: bold;
    font-size: 20px;
    line-height: 1.2;
    letter-spacing: 0.14em;
    color: #000000;
    display: flex;
    align-items: center;

    @include desktop {
      font-size: 16px;
    }
    @include mobile {
      font-size: 18px;
    }

    img {
      margin-right: 10px;
    }
  }

  &__date {
    font-family: $PTMono;
    font-size: 14px;
    line-height: 16px;
    letter-spacing: 0.14em;
    color: #b0b0b0;
    margin-top: 10px;

    @include mobile {
      margin: 0;
      font-size: 12px;
      line-height: 13px;
      max-width: 88px;
      text-align: right;
    }
  }

  &__statuses {
    display: flex;
    justify-content: flex-end;
    margin-top: 17px;
    @include mobile {
      justify-content: center;
      width: 100%;
      margin-top: 10px;
    }
  }

  &__status {
    font-family: $PTMono;
    font-size: 14px;
    line-height: 16px;
    letter-spacing: 0.14em;
    color: #b0b0b0;

    &:last-child {
      margin-left: 10px;
    }
  }

  &__payoff {
    font-weight: 900;
    font-size: 20px;
    line-height: 1.2;
    display: flex;
    align-items: center;

    span {
      margin-left: 10px;
    }

    @include desktop {
      font-size: 16px;
    }

    @include widescreen {
      font-size: 14px;
    }

    @include mobile {
      margin-top: 10px;
      width: 100%;
      justify-content: center;
      font-size: 16px;
    }

    @include rwd(360) {
      font-size: 14px;
    }
  }

  &__price {
    font-size: 14px;
    line-height: 16px;
    letter-spacing: 0.14em;
    text-transform: uppercase;

    @include widescreen {
      letter-spacing: 0;
    }

    @include mobile {
      margin-top: 20px;
    }
  }

  &__words {
    width: 42%;
    display: grid;
    // grid-template-columns: repeat(auto-fill, minmax(45px, 1fr));
    grid-template-columns: repeat(6, 1fr);
    gap: 10px;

    @include widescreen {
      grid-template-columns: repeat(4, 1fr);
    }

    @include tablet {
      width: 50%;
      grid-template-columns: repeat(6, 1fr);
    }

    @include mobile {
      width: 100%;

      //   display: flex;
      //   grid-template-columns: repeat(1, 1fr);
      //   flex-wrap: wrap;
      //   gap: 10px 50px;
      //   justify-content: space-between;
    }

    @include xmobile {
      gap: 10px 30px;
    }

    @include retina {
      gap: 10px 5px;
    }
  }

  &__word {
    font-size: 12px;
    line-height: 14px;

    @include mobile {
      display: grid;
      justify-content: center;
      &:nth-child(1),
      &:nth-child(7) {
        justify-content: flex-start;
      }
      &:nth-child(6),
      &:nth-child(12) {
        justify-content: flex-end;
      }
    }
  }
}
</style>
