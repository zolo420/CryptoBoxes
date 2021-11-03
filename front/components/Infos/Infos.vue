<template>
  <div class="infos">
    <div class="infos__block">
      <div class="container">
        <div class="page__subtitle infos__subtitle">
          КАК НАПОЛНЯЮТСЯ КОШЕЛЬКИ В БОКСАХ
        </div>
        <div class="infos__wrap">
          <div class="infos__box">
            <img src="/images/cub-orange.svg" alt="HARD BOX" />
            <div class="infos__name">HARD BOX</div>
          </div>
          <div class="infos__text">
            <div class="infos__item">
              <div class="infos__percent">80%</div>
              <div class="infos__desc">
                От стоимости билета перечисляется в фонд активного бокса
              </div>
            </div>
            <div class="infos__item">
              <div class="infos__percent">20%</div>
              <div class="infos__desc">
                От стоимости билета остается на площадке
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="infos__block">
      <div class="container">
        <div class="infos__wrap">
          <div class="infos__box">
            <img src="/images/cub-gray.svg" alt="EASY BOX" />
            <div class="infos__name">EASY BOX</div>
          </div>
          <div class="infos__text">
            <div class="infos__item">
              <div class="infos__percent">40%</div>
              <div class="infos__desc">
                От стоимости билета перечисляется в фонд активного бокса
              </div>
            </div>
            <div class="infos__item">
              <div class="infos__percent">40%</div>
              <div class="infos__desc">
                От стоимости билета перечисляется в HARD BOX
              </div>
            </div>
            <div class="infos__item">
              <div class="infos__percent">20%</div>
              <div class="infos__desc">
                От стоимости билета остается на площадке
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="infos__block">
      <div class="container">
        <div class="infos__wrap">
          <div class="infos__box">
            <img src="/images/cub-blue.svg" alt="QUEST BOX" />

            <div class="infos__name">QUEST BOX</div>
          </div>
          <div class="infos__text">
            <div class="infos__item">
              <div class="infos__percent">30%</div>
              <div class="infos__desc">
                От стоимости билета перечисляется в фонд активного бокса
              </div>
            </div>
            <div class="infos__item">
              <div class="infos__percent">30%</div>
              <div class="infos__desc">
                От стоимости билета перечисляется в HARD BOX
              </div>
            </div>
            <div class="infos__item">
              <div class="infos__percent">30%</div>
              <div class="infos__desc">
                От стоимости билета перечисляется в EASY BOX
              </div>
            </div>
            <div class="infos__item">
              <div class="infos__percent">10%</div>
              <div class="infos__desc">
                От стоимости билета остается на площадке
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Infos',
}
</script>

<style lang="scss">
.infos {
  padding-bottom: 100px;
  $self: &;
  &__subtitle {
    z-index: 50;
    @include tablet {
      margin-bottom: 30px;
      padding: 0;
    }
  }
  &__block {
    padding: 100px 0;
    position: relative;

    @include desktop {
      padding: 70px 0;
    }

    @include tablet {
      padding: 50px 0;
    }
    &::before {
      top: 0;
      content: '';
      position: absolute;
      background-color: $gray-100;
      width: calc(60% + 30px);
      height: 100%;

      @include rwd(1600) {
        width: 65%;
      }

      @include desktop {
        width: calc(70% + 30px);
      }

      @include widescreen {
        width: calc(65% + 20px);
      }

      @include rwd(810) {
        width: 63%;
      }

      @include tablet {
        width: 250px;
        left: 15px;
      }

      @include mobile {
        width: 125px;
      }
    }
    &:nth-child(1) {
      padding-top: 70px;
      @include tablet {
        padding-top: 50px;
      }
    }
    &:nth-child(2) {
      padding: 140px 0;
      @include desktop {
        padding: 70px 0;
      }

      @include tablet {
        padding: 50px 0;
      }
      &::before {
        display: none;
        @include tablet {
          display: block;
          right: 15px;
          left: auto;
        }
      }
      #{$self} {
        &__wrap {
          flex-direction: row-reverse;
          @include tablet {
            flex-direction: column;
          }
        }

        &__box {
          margin: 0 0 0 140px;
          @include desktop {
            margin: 0 0 0 70px;
          }
          @include tablet {
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: flex-end;
          }

          @include mobile {
            margin-left: auto;
          }

          img {
            @include tablet {
              order: 1;
            }
          }
        }

        &__name {
          margin: 0 20px 0 0;
          @include rwd(360) {
            margin: 0 10px 0 0;
          }
        }
      }
    }

    &:last-child {
      &::before {
        right: 0;
        left: auto;

        @include tablet {
          right: 15auto;
          left: 15px;
        }
      }
    }
  }
  &__wrap {
    display: flex;
    align-items: center;
    position: relative;

    @include tablet {
      flex-direction: column;
      align-items: flex-start;
      padding: 0 30px;
    }

    @include rwd(360) {
      padding: 0 10px;
    }
  }

  &__box {
    margin-right: 140px;

    @include desktop {
      margin-right: 70px;
    }
    @include tablet {
      margin: 0;
    }
    @include tablet {
      width: 100%;
      margin-bottom: 20px;
      display: flex;
      align-items: center;
    }
    @include mobile {
      max-width: 150px;
    }
  }

  &__text {
    @include widescreen {
      width: calc(100% - 300px);
    }
    @include tablet {
      width: 100%;
    }
  }

  &__item {
    margin-bottom: 35px;

    @include tablet {
      margin-bottom: 10px;
    }
    &:last-child {
      margin-bottom: 0;
    }
  }

  &__percent {
    font-weight: 900;
    font-size: 48px;
    line-height: 68px;
    letter-spacing: 0.02em;

    @include desktop {
      font-size: 36px;
      line-height: 1;
    }

    @include tablet {
      font-size: 40px;
    }

    @include rwd(360) {
      font-size: 30px;
    }
  }

  &__desc {
    font-family: $PTMono;
    font-style: normal;
    font-weight: normal;
    font-size: 20px;
    line-height: 22px;
    @include tablet {
      font-size: 18px;
      line-height: 20px;
    }
    @include rwd(360) {
      font-size: 16px;
    }
  }

  &__name {
    font-weight: bold;
    font-size: 20px;
    line-height: 23px;
    text-align: center;
    letter-spacing: 0.14em;
    display: none;
    margin-left: 20px;
    white-space: nowrap;
    @include tablet {
      display: block;
    }

    @include rwd(360) {
      font-size: 16px;
      margin-left: 10px;
    }
  }
}
</style>
