<template>
  <div class="page__wrap">
    <client-only>
      <the-header />
    </client-only>
    <Nuxt />
    <the-footer />
    <client-only>
      <auth-modal />
    </client-only>
    <invite-modal />
  </div>
</template>

<script>
import TheHeader from '@/layouts/components/TheHeader'
import TheFooter from '@/layouts/components/TheFooter'
import AuthModal from '@/layouts/components/modal/AuthModal'
import InviteModal from '@/layouts/components/modal/InviteModal'
export default {
  components: { TheHeader, TheFooter, AuthModal, InviteModal },
}
</script>

<style lang="scss">
.page {
  &__wrap {
    display: flex;
    flex-direction: column;
    min-height: 100vh;
  }

  &__subtitle {
    font-family: 'Arial';
    font-weight: bold;
    font-size: 40px;
    line-height: 46px;
    text-align: center;
    letter-spacing: 0.14em;
    padding-bottom: 20px;
    margin-bottom: 70px;
    position: relative;

    @include widescreen {
      font-size: 30px;
      line-height: 34px;
    }

    @include tablet {
      font-size: 22px;
      line-height: 25px;
    }

    &::before {
      content: '';
      position: absolute;
      left: 0;
      height: 3px;
      width: 50%;
      bottom: 0;
      display: none;
    }
    &--right {
      &::before {
        left: auto;
        right: 0;
      }
    }
    &--orange {
      &::before {
        display: block;
        background-color: $orange;
      }
    }

    &--blue {
      &::before {
        display: block;
        background-color: $blue-100;
      }
    }

    &--gray {
      &::before {
        display: block;
        background-color: $gray;
      }
    }

    &--ttu {
      text-transform: uppercase;
    }
  }
}
</style>
