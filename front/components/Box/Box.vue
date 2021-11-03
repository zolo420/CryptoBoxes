<template>
  <div
    v-if="box"
    class="Box"
    :class="{ 'Box--open': isOpen }"
    @mouseenter="mouseEnter"
    @mouseleave="mouseLeave"
  >
    <div class="Box__cub" :class="classes">
      <div class="Box__side" :class="{ 'Box__side--small': isSmall }"></div>
      <div class="Box__side" :class="{ 'Box__side--small': isSmall }"></div>
      <div class="Box__side" :class="{ 'Box__side--small': isSmall }"></div>
      <SlideYUpTransition :duration="500">
        <div
          v-if="isVisible"
          class="Box__side"
          :class="{ 'Box__side--small': isSmall }"
        ></div>
      </SlideYUpTransition>
      <SlideXRightTransition :duration="500">
        <div
          v-if="isVisible"
          class="Box__side"
          :class="{ 'Box__side--small': isSmall }"
        ></div>
      </SlideXRightTransition>
      <SlideXLeftTransition :duration="500">
        <div
          v-if="isVisible"
          class="Box__side"
          :class="{ 'Box__side--small': isSmall }"
        ></div>
      </SlideXLeftTransition>
      <FadeTransition>
        <div
          v-if="isVisible"
          class="Box__line"
          :class="{ 'Box__line--small': isSmall }"
          :style="{ backgroundColor: currentBackgroundLine }"
        ></div>
      </FadeTransition>

      <FadeTransition>
        <div
          v-if="isVisible"
          class="Box__currency"
          :class="{ 'Box__currency--small': isSmall }"
        >
          <svg
            v-if="box.currency === 'ethereum'"
            width="47"
            height="90"
            viewBox="0 0 47 90"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              fill-rule="evenodd"
              clip-rule="evenodd"
              d="M23.2766 0.499686C23.2349 0.556755 22.1313 2.0488 20.824 3.81523C19.5168 5.58166 18.0602 7.55719 17.5873 8.20533C17.1142 8.85338 15.1463 11.5255 13.214 14.1431C11.2817 16.7608 9.51752 19.1537 9.29341 19.4607C8.64747 20.3457 2.05088 29.2849 1.02655 30.6634C0.516647 31.3496 0.0598328 32.0087 0.0115724 32.1278C-0.048904 32.2773 0.126038 32.5966 0.573955 33.1544C1.22864 33.9696 3.86728 37.3067 9.29265 44.1806C10.9101 46.2299 14.7232 51.061 17.7661 54.9164C20.8089 58.7717 23.3428 61.9517 23.3968 61.9829C23.4508 62.014 24.8295 61.8871 26.4607 61.7007C28.0917 61.5144 30.58 61.2341 31.9901 61.0779C33.4002 60.9216 35.4362 60.6933 36.5145 60.5705C37.5929 60.4476 40.3075 60.1477 42.5471 59.9038C44.7867 59.66 46.6795 59.4348 46.7534 59.4032C46.8275 59.3718 46.5489 58.4921 46.1335 57.4457C45.7186 56.4004 44.0029 52.0928 42.3209 47.8733C40.6389 43.6538 39.0787 39.7382 38.8538 39.172C38.6288 38.6057 36.6806 33.7124 34.5243 28.2978C32.3679 22.8832 29.0262 14.4878 27.0982 9.64144C25.1703 4.79512 23.5387 0.732121 23.4726 0.612883C23.4066 0.493468 23.3183 0.442528 23.2766 0.499686ZM0.0930107 37.8503C0.0930107 37.911 1.1668 40.3433 2.47919 43.2558C5.71505 50.437 9.16386 58.1015 12.3089 65.1018C17.0496 75.6536 19.7356 81.6255 20.4488 83.2006C20.8353 84.054 21.6512 85.8633 22.2619 87.2209C23.2909 89.509 23.3876 89.6745 23.5842 89.483C23.964 89.1132 31.689 80.8785 41.1111 70.7998C42.9656 68.816 44.9806 66.6666 45.5887 66.0233C46.197 65.3801 46.6945 64.8077 46.6945 64.7514C46.6945 64.6118 45.6315 64.7194 33.9507 66.0421C28.2487 66.6877 25.186 67.029 24.2906 67.1181L23.3779 67.2093L19.54 62.3464C17.4292 59.672 14.5824 56.0686 13.2138 54.3391C11.8452 52.6095 8.65546 48.5737 6.12556 45.3704C3.59566 42.1672 1.20345 39.14 0.809376 38.6433C0.4153 38.1466 0.0930107 37.7898 0.0930107 37.8503Z"
              :fill="currentColorIcon"
            />
          </svg>

          <svg
            v-if="box.currency === 'bitcoin'"
            width="50"
            height="93"
            viewBox="0 0 50 93"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              fill-rule="evenodd"
              clip-rule="evenodd"
              d="M12.853 0.471391C12.83 0.485252 12.8113 3.27365 12.8113 6.66782L12.8113 12.8389L11.1396 11.8789C10.2201 11.3509 7.33762 9.68456 4.73392 8.17576L-2.73897e-07 5.43263L-3.62517e-07 9.45522L-4.51137e-07 13.4778L2.60913 14.985C4.85685 16.2834 5.28319 16.5474 5.68696 16.8907C6.92522 17.9436 7.77232 19.3315 8.14823 20.9235C8.24128 21.3175 8.24865 22.8407 8.23397 38.6718L8.21797 55.9891L8.03798 56.3468C7.82982 56.7608 7.38561 57.0376 6.96534 57.0153C6.51094 56.9911 5.68021 56.5754 3.3918 55.2273L1.25294 53.9673L1.22088 54.1339C1.16364 54.4316 -1.522e-06 62.0862 -1.52374e-06 62.165C-1.52489e-06 62.217 1.86501 63.3182 5.83357 65.6094C9.04208 67.4619 11.9246 69.1477 12.2392 69.3559L12.8113 69.7342L12.8113 75.9807L12.8113 82.2271L15.9985 84.0672L19.1857 85.9074L19.1857 79.7283C19.1857 76.3297 19.2067 73.551 19.2325 73.5533C19.2583 73.5556 20.4114 74.2205 21.7948 75.0307L24.3102 76.5039L24.3102 82.685L24.3102 88.866L27.4974 90.7061L30.6846 92.5463L30.6846 86.295L30.6846 80.0439L31.1377 80.2613C33.0072 81.1587 33.9641 81.6021 34.7606 81.9397C39.2691 83.8509 42.5807 84.4226 44.9814 83.7042C45.714 83.4851 46.9307 82.7203 47.4467 82.1546C48.8862 80.5769 49.675 77.9987 49.8719 74.2283C50.2084 67.7812 48.0938 62.0632 43.5584 57.1561C42.8781 56.4201 41.5862 55.1593 41.0071 54.666L40.6744 54.3827L41.1464 54.3364C42.6788 54.1862 43.8155 53.6192 44.6531 52.5873C45.7201 51.2727 46.1897 49.4621 46.1897 46.6627C46.1897 42.5893 45.234 39.0672 43.1558 35.4818C40.7752 31.3746 36.8804 27.4473 31.4193 23.6476L30.6853 23.1369L30.6693 16.9365L30.6533 10.7361L27.4818 8.88578L24.3102 7.03549L24.3102 13.0598L24.3102 19.0839L22.9509 18.3478C22.2034 17.943 21.0503 17.2992 20.3887 16.9174L19.1857 16.223L19.1857 10.1506L19.1857 4.07819L16.0402 2.26213C14.3101 1.26326 12.8758 0.457418 12.853 0.471391ZM25.935 29.0784C30.1496 31.9836 32.6903 34.9376 33.7193 38.1287C34.0704 39.2177 34.1844 39.849 34.227 40.9397C34.2837 42.396 34.0678 43.4213 33.5454 44.1748C33.2391 44.6168 32.439 45.1235 31.872 45.2347C30.4363 45.5163 28.4321 45.0462 25.6851 43.7834C24.5539 43.2634 20.8664 41.2328 19.9825 40.6432L19.3732 40.2367L19.3732 32.7291L19.3732 25.2215L20.3262 25.7439C21.8967 26.6046 25.1662 28.5484 25.935 29.0784ZM27.1224 52.4223C30.4972 54.7216 32.8629 56.8547 34.522 59.0941C35.5116 60.4298 36.319 61.962 36.7178 63.2605C37.1053 64.5225 37.2878 66.0382 37.1849 67.1406C37.0988 68.0636 36.9787 68.4866 36.612 69.1589C36.3297 69.6765 36.217 69.7934 35.6904 70.1151C34.8342 70.6381 34.0202 70.769 32.6485 70.6044C30.1258 70.3016 25.8286 68.3955 20.9698 65.4243L19.3732 64.4479L19.3732 56.1648L19.3732 47.8818L20.3574 48.4228C22.1031 49.3824 26.3181 51.8743 27.1224 52.4223Z"
              :fill="currentColorIcon"
            />
          </svg>
        </div>
      </FadeTransition>
      <div
        class="Box__currency Box__currency--active"
        :class="{ 'Box__currency--center': isSmall }"
      >
        <img
          v-if="box.currency === 'ethereum'"
          src="/images/ethereum.svg"
          alt="Ethereum"
        />
        <img
          v-if="box.currency === 'bitcoin'"
          src="/images/bitcoin.svg"
          alt="Bitcoin"
        />
      </div>
    </div>

    <template v-if="isBox">
      <div class="Box__title">{{ box.title }}</div>
      <div v-if="box.price" class="Box__price">
        {{ box.starting_bank }}
        <Icon :icon-name="currentIcon" />
      </div>

      <div class="Box__btn">
        <Button>Открыть за {{ box.price }}$</Button>
      </div>
      <div class="Box__number">
        №
        <span>{{ box.number }}</span>
      </div>
    </template>
  </div>
</template>

<script>
import {
  FadeTransition,
  SlideYUpTransition,
  SlideXLeftTransition,
  SlideXRightTransition,
} from 'vue2-transitions'
import Button from '../Button/Button'
import Icon from '@/components/Icon'

export default {
  name: 'Box',
  components: {
    FadeTransition,
    SlideYUpTransition,
    SlideXLeftTransition,
    SlideXRightTransition,
    Icon,
    Button,
  },
  props: {
    box: {
      type: Object,
      default: null,
    },
    isBox: {
      type: Boolean,
      default: true,
    },
    type: {
      type: String,
      default: '',
    },
    isSmall: {
      type: Boolean,
    },
    isShadow: {
      type: Boolean,
    },

    isOpen: {
      type: Boolean,
      default: false,
    },
  },

  data() {
    return {
      isVisible: !this.isOpen,
    }
  },

  computed: {
    classes() {
      return {
        'Box__cub--blue': this.box.color === 'blue',
        'Box__cub--orange': this.box.color === 'orange',
        'Box__cub--small': this.isSmall,
        'Box__cub--shadow': this.isShadow,
      }
    },
    currentIcon() {
      return this.currency === 'bitcoin' ? 'bitcoin' : 'ethereum'
    },
    currentBackgroundLine() {
      switch (this.type) {
        case 'hard':
          return '#D43C0D'
        case 'easy':
          return '#B0B0B0'
        case 'quest':
          return '#323E95'
        default:
          return '#fff'
      }
    },
    currentColorIcon() {
      switch (this.box.color) {
        case 'blue':
        case 'orange':
          return 'white'
        default:
          return 'black'
      }
    },
  },

  methods: {
    mouseEnter() {
      if (!this.isOpen) {
        this.isVisible = false
      }
    },
    mouseLeave() {
      if (!this.isOpen) {
        this.isVisible = true
      }
    },
  },
}
</script>

<style lang="scss">
.Box {
  $self: &;
  &--open,
  &:hover {
    #{$self} {
      &__currency {
        &--active {
          opacity: 1;
          animation: topBottom 3s infinite;

          &::after {
            animation: smallToLarge 3s infinite;
          }
        }
      }

      &__side {
        &:nth-child(4) {
          top: -70%;
        }

        &:nth-child(5) {
          right: -70%;
        }

        &:nth-child(6) {
          left: -70%;
        }
      }
    }
  }
  &__line {
    position: absolute;
    left: 38px;
    top: 60px;
    width: 172px;
    height: 16px;
    transform: matrix(0.71, 0.41, -1.22, 0.71, 0, 0);

    &--small {
      left: 15px;
      top: 25px;
      width: 71px;
      height: 8px;
    }
  }

  &__side {
    position: absolute;
    transition: all 1s ease;
    &:first-child {
      width: 122px;
      height: 122px;
      background-color: #b0b0b0;
      transform: skew(-180deg, -210deg);
      top: 35px;
    }

    &:nth-child(2) {
      width: 122px;
      height: 122px;
      background-color: #e6e6e6;
      transform: skew(180deg, 210deg);
      right: 0;
      top: 35px;
    }

    &:nth-child(3) {
      width: 142px;
      height: 122px;
      background-color: #d2d2d2;
      transform: rotate(150deg) skew(30deg, 0deg);
      bottom: 11px;
      left: 51px;
    }

    &:nth-child(4) {
      background: #edeff5;
      width: 142px;
      height: 122px;
      transform: rotate(150deg) skew(30deg, 0deg);
      left: 51px;
      top: 8px;
    }
    &:nth-child(5) {
      width: 122px;
      height: 125px;
      background-color: #dedfe4;
      transform: skew(180deg, 210deg);
      bottom: 35px;
    }
    &:nth-child(6) {
      width: 122px;
      height: 125px;
      background-color: #ccceda;
      transform: skew(-180deg, -210deg);
      bottom: 35px;
      right: 0;
    }

    &--small {
      &:first-child {
        width: 50px;
        height: 60px;
        top: 15px;
      }
      &:nth-child(2) {
        width: 50px;
        height: 60px;
        top: 15px;
      }
      &:nth-child(3) {
        width: 58px;
        height: 51px;
        left: 21px;
        bottom: 6px;
      }
      &:nth-child(4) {
        width: 58px;
        height: 51px;
        top: 4px;
        left: 21px;
      }
      &:nth-child(5) {
        width: 50px;
        height: 60px;
        bottom: 16px;
      }
      &:nth-child(6) {
        width: 50px;
        height: 60px;
        bottom: 16px;
      }
    }
  }

  &__cub {
    width: 244px;
    height: 264px;
    position: relative;
    margin-bottom: 10px;

    &--small {
      width: 100px;
      height: 120px;
      // background-color: #323e95;
    }

    &--blue {
      #{$self} {
        &__currency {
          &::after {
            background: radial-gradient(
              35.11% 35.11% at 49.7% 64.89%,
              rgba(0, 13, 104, 0.53) 14.58%,
              rgba(50, 62, 149, 0) 100%
            );
          }
        }
        &__side {
          &:first-child {
            background-color: #323e95;
          }

          &:nth-child(2) {
            background-color: #5d69be;
          }

          &:nth-child(3) {
            background-color: #4854af;
          }
          &:nth-child(4) {
            background-color: #5d69be;
          }
          &:nth-child(5) {
            background-color: #4854af;
          }
          &:nth-child(6) {
            background-color: #323e95;
          }
        }
      }
    }

    &--orange {
      #{$self} {
        &__currency {
          &::after {
            background: radial-gradient(
              35.11% 35.11% at 49.7% 64.89%,
              rgba(95, 0, 0, 0.39) 14.58%,
              rgba(75, 0, 0, 0) 100%
            );
          }
        }
        &__side {
          &:first-child {
            background-color: #d43c0d;
          }

          &:nth-child(2) {
            background-color: #fa673a;
          }

          &:nth-child(3) {
            background-color: #fe4d17;
          }

          &:nth-child(4) {
            background-color: #fa673a;
          }
          &:nth-child(5) {
            background-color: #fe4d17;
          }
          &:nth-child(6) {
            background-color: #d53c0d;
          }
        }
      }
    }

    &--shadow {
      &::before {
        content: '';
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
        bottom: -83px;
        width: 356px;
        height: 147px;

        background-image: radial-gradient(
          58.16% 35.15% at 50% 58.55%,
          rgba(0, 0, 0, 0.2) 0%,
          rgba(60, 60, 60, 0) 74.48%
        );

        @include tablet {
          width: 280px;
          height: 100px;
          bottom: -50px;
        }

        @include rwd(530) {
          width: 203.3px;
          height: 83.95px;
          bottom: -50px;
          opacity: 0.4;
        }
      }
    }
  }

  &__currency {
    position: absolute;
    left: 30px;
    bottom: 50px;
    transition: all 0.5s ease;

    img {
      max-width: 100%;
      height: auto;
      display: block;
    }

    svg {
      max-width: 100%;
      height: 100%;
    }

    &--small {
      max-width: 20px;
      left: 12px;
      bottom: 25px;
    }

    &--active {
      left: 50%;
      transform: translateX(-50%);
      bottom: 60px;
      opacity: 0;
      z-index: 50;
      transition: all 1s ease;

      &::after {
        content: '';
        width: 165px;
        height: 47px;
        left: 50%;
        transform: translateX(-50%);
        background: radial-gradient(
          35.11% 35.11% at 49.7% 64.89%,
          #b3b3b3 14.58%,
          rgba(196, 196, 196, 0) 100%
        );
        bottom: -25px;
        z-index: -1;
        position: absolute;
      }
    }

    &--center {
      max-width: 40px;
      bottom: 40px;
    }
  }

  &__title {
    font-weight: bold;
    font-size: 20px;
    line-height: 23px;
    text-align: center;
    letter-spacing: 0.14em;
    color: #000000;
    margin-bottom: 6px;
  }

  &__price {
    font-weight: 900;
    font-size: 20px;
    line-height: 28px;
    margin-bottom: 9px;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  &__btn {
    text-align: center;
  }

  &__number {
    font-family: $PTMono;
    font-size: 20px;
    line-height: 22px;
    letter-spacing: 0.14em;

    display: flex;
    align-items: center;
    justify-content: center;
    margin-top: 10px;

    span {
      color: #b0b0b0;
    }
  }
}

@keyframes topBottom {
  0% {
    transform: translate3d(-50%, -15%, 0);
  }
  50% {
    transform: translate3d(-50%, 15%, 0);
  }
  100% {
    transform: translate3d(-50%, -15%, 0);
  }
}

@keyframes smallToLarge {
  0% {
    transform: translateX(-50%) scale(1);
  }
  50% {
    transform: translateX(-50%) scale(0.4);
  }
  100% {
    transform: translateX(-50%) scale(1);
  }
}
</style>
