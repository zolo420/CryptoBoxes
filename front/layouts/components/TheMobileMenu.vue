<template>
  <div class="mobile">
    <TheUser class="mobile__user" />
    <TheMenu
      class-list="mobile__list"
      class-item="mobile__item"
      @change-menu="$emit('change-menu')"
    />
  </div>
</template>

<script>
import TheMenu from './TheMenu'
import TheUser from './TheUser'
export default {
  name: 'MobileMenu',
  components: { TheMenu, TheUser },
}
</script>

<style lang="scss">
.mobile {
  background-color: $white;
  position: fixed;
  min-height: 100vh;
  width: 100%;
  left: 0;
  top: 0;
  z-index: 150;
  padding: 120px 15px;

  &__user {
    margin: 0 auto 30px;
  }

  &__list {
    &.menu__list {
      @include mobile {
        flex-direction: column;
        align-items: center;
      }
    }
  }

  &__item {
    &.menu__item {
      margin: 0 0 30px;

      &:last-child {
        margin: 0;
      }
    }
  }
}
</style>
