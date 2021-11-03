<template>
  <div class="invites">
    <div class="invites__top">
      <div class="invites__title">Ваша история приглашения друзей</div>
      <Button :fluid="$breakpoints.width <= 480" @click="openModal">
        Пригласить
      </Button>
    </div>

    <div class="invites__list">
      <Invite v-for="invite in invites" :key="invite.id" :invite="invite" />
    </div>
  </div>
</template>

<script>
import Button from '~/components/Button/Button.vue'
import Invite from '~/components/Invites/Invite.vue'
export default {
  name: 'Invites',
  components: { Button, Invite },
  layout: 'profile',

  data() {
    return {
      invites: [],
    }
  },

  head() {
    return {
      title: 'Профиле | Инвайты',
    }
  },

  mounted() {
    this.$axios.get('/profile/invitation-history').then((res) => {
      this.invites = res.data.items
    })
  },

  methods: {
    openModal() {
      this.$store.commit('modals/SET_MODAL', {
        name: 'invite',
      })
    },
  },
}
</script>

<style lang="scss">
.invites {
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

  &__title {
    font-weight: bold;
    font-size: 14px;
    line-height: 16px;
    letter-spacing: 0.14em;
    text-transform: uppercase;
    color: $red;

    @include tablet {
      font-size: 12px;
      line-height: 14px;
    }

    @include xmobile {
      text-align: center;
      width: 100%;
      margin-top: 30px;
    }
  }

  &__list {
    margin-top: 30px;
  }
}
</style>
