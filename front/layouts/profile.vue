<template>
  <client-only>
    <div class="page__wrap">
      <client-only>
        <the-header />
      </client-only>
      <div class="container profile__container">
        <div class="profile">
          <div class="profile__aside">
            <nuxt-link
              v-for="item in menu"
              :key="item.id"
              :to="item.link"
              class="profile__route"
            >
              <Icon
                :icon-name="item.icon"
                fill="none"
                :width="24"
                :height="24"
              />
              <template v-if="$breakpoints.width > 768">
                {{ item.title }}
              </template>
            </nuxt-link>
          </div>
          <div class="profile__content">
            <Nuxt />
          </div>
        </div>
      </div>
      <the-footer />
      <invite-modal />
    </div>
  </client-only>
</template>

<script>
import TheHeader from '@/layouts/components/TheHeader'
import TheFooter from '@/layouts/components/TheFooter'
import InviteModal from '@/layouts/components/modal/InviteModal'
import Icon from '@/components/Icon'
export default {
  name: 'ProfileLayout',
  components: { TheHeader, TheFooter, Icon, InviteModal },
  middleware: 'auth',
  data() {
    return {
      menu: [
        { id: 1, link: '/profile', title: 'Профиль', icon: 'user' },
        { id: 2, link: '/profile/balance', title: 'Мой счет', icon: 'cart' },
        {
          id: 3,
          link: '/profile/history',
          title: 'История открытых кейсов',
          icon: 'cub',
        },
        { id: 4, link: '/profile/invites', title: 'Инвайты', icon: 'send' },
      ],
    }
  },
}
</script>

<style lang="scss">
.page {
  &__wrap {
    display: flex;
    flex-direction: column;
    min-height: 100vh;
  }
}

.profile {
  display: flex;
  margin-top: 20px;
  padding-bottom: 100px;
  @include tablet {
    flex-direction: column;
    padding-bottom: 50px;
  }

  &__container {
    @include tablet {
      padding: 0;
    }
  }
  &__aside {
    max-width: 285px;
    width: 100%;
    display: flex;
    flex-direction: column;
    @include widescreen {
      max-width: 230px;
    }
    @include tablet {
      max-width: 100%;
      flex-direction: row;
      padding: 0 15px;
    }
  }
  &__content {
    max-width: calc(100% - 285px);
    width: 100%;
    background-color: $gray-100;
    @include widescreen {
      max-width: calc(100% - 230px);
    }
    @include tablet {
      max-width: 100%;
      padding: 0 15px;
    }
  }

  &__route {
    padding: 13px 20px 13px 34px;
    font-weight: bold;
    font-size: 14px;
    line-height: 16px;
    letter-spacing: 0.14em;
    text-transform: uppercase;
    color: #000000;
    display: flex;
    align-items: center;

    @include widescreen {
      font-size: 12px;
      line-height: 14px;
      padding: 13px 15px;
    }

    @include tablet {
      padding: 18px 26px;
    }

    svg {
      margin-right: 20px;
      min-width: 24px;
      path {
        stroke: #000000;
      }
      @include widescreen {
        margin-right: 10px;
      }
      @include tablet {
        margin: 0;
      }
    }

    &.nuxt-link-exact-active {
      color: #4854af;
      background-color: $gray-100;
      svg {
        path {
          stroke: #4854af;
        }
      }
    }
  }
}
</style>
