<template>
  <footer class="footer">
    <div class="container">
      <div class="footer__line">
        <TheLogo class="footer__logo" />
        <TheMenu class-list="footer__list" class-item="footer__item" />
      </div>
    </div>
  </footer>
</template>

<script>
import TheLogo from '@/layouts/components/TheLogo'
import TheMenu from '@/layouts/components/TheMenu'
export default {
  name: 'Footer',
  components: { TheLogo, TheMenu },
}
</script>

<style lang="scss">
.footer {
  margin-top: auto;
  background-color: $gray-100;
  padding: 12px 0;
  @include xmobile {
    flex-direction: column-reverse;
    padding: 30px 0;
  }
  &__line {
    display: flex;
    align-items: center;
    justify-content: space-between;

    @include xmobile {
      flex-direction: column-reverse;
    }
  }

  &__logo {
    @include xmobile {
      margin-top: 60px;
    }
  }

  &__list {
    @include xmobile {
      flex-direction: column;
      align-items: center;
    }
  }

  &__item {
    @include xmobile {
      margin: 0 0 30px 0 !important;
      text-align: center;

      &:last-child {
        margin: 0;
      }
    }
  }
}
</style>
