<template>
  <a href="#" class="User" @click.prevent="openLogin">
    <Icon icon-name="user" fill="none" />
  </a>
</template>

<script>
import Icon from '@/components/Icon'
export default {
  name: 'User',
  components: { Icon },
  methods: {
    openLogin() {
      if (this.$store.state.auth.token) {
        this.$router.push('/profile')
      } else {
        this.$store.commit('modals/SET_MODAL', {
          name: 'login',
        })
      }
    },
  },
}
</script>

<style lang="scss">
.User {
  width: 30px;
  height: 30px;
  border-radius: 50%;
  background-color: $orange;
  display: flex;
  align-items: center;
  justify-content: center;

  svg {
    path {
      stroke: $white;
    }
  }
}
</style>
