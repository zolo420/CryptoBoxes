<template>
  <div class="field">
    <input
      :value="value"
      :type="currentType"
      :placeholder="!!placeholder ? placeholder : null"
      v-bind="$attrs"
      class="field__control"
      :class="{ 'field__control--error': !!textError }"
      v-on="{
        ...$listeners,
        input: (event) => $emit('input', event.target.value),
        focus: (event) => $emit('focus', event),
        blur: (event) => $emit('blur', event),
      }"
    />

    <button
      v-if="type === 'password' && isIcon"
      type="button"
      class="field__icon"
      :class="{ 'field__icon--open': isVisiblle }"
      @click="isVisiblle = !isVisiblle"
    >
      <icon icon-name="key" fill="none" />
    </button>

    <transition name="slide-fade-down">
      <div v-if="!!textError" class="field__error">{{ textError }}</div>
    </transition>
  </div>
</template>

<script>
import Icon from '../Icon/Icon.vue'
export default {
  name: 'Field',
  components: { Icon },
  props: {
    value: {
      type: String,
      default: '',
    },
    type: {
      type: String,
      default: 'text',
    },
    textError: {
      type: String,
      default: '',
    },
    placeholder: {
      type: String,
      default: '',
    },
    isIcon: {
      type: Boolean,
      default: false,
    },
  },
  data() {
    return {
      isVisiblle: false,
    }
  },

  computed: {
    currentType() {
      return this.isVisiblle && this.type === 'password' ? 'text' : this.type
    },
  },
}
</script>

<style lang="scss">
.field {
  position: relative;
  width: 100%;
  &__control {
    width: 100%;
    font-family: $PTMono;
    font-size: 18px;
    line-height: 20px;
    letter-spacing: 0.14em;
    color: #000000;
    border: none;
    border-bottom: 1px solid #b0b0b0;
    background-color: transparent;
    padding-bottom: 5px;
    &::placeholder {
      opacity: 1;
      color: #b0b0b0;
    }

    &--error {
      border-bottom: 1px solid $red;

      animation-name: shakeError;
      animation-fill-mode: forwards;
      animation-duration: 0.6s;
      animation-timing-function: ease-in-out;
    }
  }

  &__icon {
    position: absolute;
    right: 0;
    bottom: 0;
    padding: 0;

    svg {
      path {
        stroke: #000000;
      }
    }

    &--open {
      svg {
        path {
          stroke: #b0b0b0;
        }
      }
    }
  }

  &__error {
    margin-top: 5px;
    position: absolute;
    font-size: 12px;
    color: $red;
    line-height: 1;
    left: 0;
  }
}

@keyframes shakeError {
  0% {
    transform: translateX(0);
  }
  15% {
    transform: translateX(0.375rem);
  }
  30% {
    transform: translateX(-0.375rem);
  }
  45% {
    transform: translateX(0.375rem);
  }
  60% {
    transform: translateX(-0.375rem);
  }
  75% {
    transform: translateX(0.375rem);
  }
  90% {
    transform: translateX(-0.375rem);
  }
  100% {
    transform: translateX(0);
  }
}
</style>
