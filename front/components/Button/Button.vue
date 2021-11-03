<template>
  <component
    :is="component"
    class="button"
    :class="[classNames]"
    :type="type"
    :disabled="disabled"
    :href="component === 'a' ? href : null"
    v-on="listeners"
  >
    <slot />
  </component>
</template>

<script>
export default {
  name: 'Button',
  props: {
    component: {
      type: String,
      default: 'button',
    },
    type: {
      type: String,
      default: 'button',
    },

    to: {
      type: String || Object,
      default: '' || null,
    },

    href: {
      type: String,
      default: '#',
    },

    disabled: {
      type: Boolean,
    },
    gray: {
      type: Boolean,
    },
    dark: {
      type: Boolean,
    },
    blue: {
      type: Boolean,
    },
    fluid: {
      type: Boolean,
    },
    medium: {
      type: Boolean,
    },
    large: {
      type: Boolean,
    },
    small: {
      type: Boolean,
    },
    outline: {
      type: Boolean,
    },
    big: {
      type: Boolean,
    },
  },
  computed: {
    classNames() {
      return {
        'button--blue': this.blue,
        'button--gray': this.gray,
        'button--dark': this.dark,
        'button--fluid': this.fluid,
        'button--large': this.large,
        'button--small': this.small,
        'button--big': this.big,
        'button--medium': this.medium,
        'button--outline': this.outline && this.dark,
      }
    },
    listeners() {
      return {
        ...this.$listeners,
        click: (event) => this.clickButton(event),
      }
    },
  },
  methods: {
    routerPush() {
      this.$router.push(this.to)
    },

    clickButton(event) {
      this.$emit('click', event)
      if (this.to) {
        this.routerPush()
      }
    },
  },
}
</script>

<style lang="scss">
@import './Button.scss';
</style>
