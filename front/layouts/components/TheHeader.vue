<template>
  <header class="header">
    <div class="container">
      <div class="header__line">
        <TheLogo class="header__logo" />

        <template v-if="$breakpoints.width > 576">
          <TheMenu class="header__menu" />
          <client-only>
            <TheUser class="header__user" />
          </client-only>
        </template>

        <Toggle
          v-if="$breakpoints.width <= 576"
          :is-toggle="isToggle"
          @toggle="isToggle = !isToggle"
        />
        <transition name="fade">
          <TheMobileMenu v-if="isToggle" @change-menu="isToggle = false" />
        </transition>
      </div>
    </div>
  </header>
</template>

<script>
import TheLogo from '@/layouts/components/TheLogo'
import TheMenu from '@/layouts/components/TheMenu'
import TheUser from '@/layouts/components/TheUser'
import TheMobileMenu from '@/layouts/components/TheMobileMenu'
import Toggle from '@/components/Toggle'
export default {
  name: 'Header',
  components: { TheLogo, TheMenu, TheUser, Toggle, TheMobileMenu },
  data() {
    return {
      isToggle: false,
    }
  },

  watch: {
    $route() {
      if (this.isToggle) {
        this.isToggle = false
      }
    },
  },
}
</script>

<style lang="scss">
.header {
  &__line {
    padding: 15px 0;
    display: flex;
    align-items: center;

    @include mobile {
      justify-content: space-between;
    }
  }

  &__logo {
    position: relative;
    z-index: 151;
  }

  &__menu {
    margin: 0 40px 0 auto;
  }
}
</style>
