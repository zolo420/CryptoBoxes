<template>
  <a class="toggle" :class="[classes]" href="#" @click.prevent="toggleMenu">
    <span class="toggle__text">Меню</span>
    <span class="toggle__burger" :class="{ 'toggle__burger--open': toggle }">
      <span class="toggle__line"></span>
      <span class="toggle__line"></span>
      <span class="toggle__line"></span>
    </span>
  </a>
</template>

<script>
export default {
  name: 'Toggle',
  props: {
    classes: {
      type: String,
      default: '',
    },
    isToggle: Boolean,
  },
  computed: {
    toggle() {
      return this.isToggle
    },
  },
  methods: {
    toggleMenu() {
      this.$emit('toggle')
    },
  },
}
</script>

<style lang="scss">
@import './Toggle.scss';
</style>
