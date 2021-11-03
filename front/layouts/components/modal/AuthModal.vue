<template>
  <client-only>
    <VueModal
      :based-on="visible"
      wrapper-class="animate__animated AuthModal"
      modal-class="AuthModal__wrap"
      in-class="animate__fadeInDown"
      out-class="animate__fadeOutDown"
      :base-zindex="9999"
      @close="close"
      @before-open="beforeOpen"
      @before-close="beforeClose"
    >
      <template #titlebar>
        <button class="AuthModal__close" type="button" @click="close">
          <svg
            width="14"
            height="14"
            viewBox="0 0 14 14"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              d="M13 1L1 13"
              stroke="black"
              stroke-width="2"
              stroke-linecap="round"
              stroke-linejoin="round"
            />
            <path
              d="M1 1L13 13"
              stroke="black"
              stroke-width="2"
              stroke-linecap="round"
              stroke-linejoin="round"
            />
          </svg>
        </button>
      </template>
      <template #content>
        <div class="AuthModal__title">
          Чтобы увидеть результат, <br />
          авторизируйся и купи билет.
        </div>
        <div class="AuthModal__subtitle">
          В стоимость билета <br />
          включено 12 попыток.
        </div>
        <div class="AuthModal__text">
          80% от стоимости билета идёт <br />
          на пополнение кошелька.
        </div>
        <div class="AuthModal__form">
          <keep-alive>
            <component
              :is="currentComponent"
              @change-form="(val) => (activeForm = val)"
            />
          </keep-alive>
        </div>
      </template>
    </VueModal>
  </client-only>
</template>

<script>
export default {
  name: 'AuthModal',
  components: {
    LoginForm: () => import('@/components/forms/LoginForm'),
    RegisterForm: () => import('@/components/forms/RegisterForm'),
    ResetForm: () => import('@/components/forms/ResetForm'),
  },
  data() {
    return {
      name: 'login',
      activeForm: 1,
    }
  },
  computed: {
    visible() {
      return !!(this.name === this.$store.state.modals.currentModal)
    },
    currentComponent() {
      switch (this.activeForm) {
        case 1: {
          return 'LoginForm'
        }
        case 2: {
          return 'RegisterForm'
        }
        case 3: {
          return 'ResetForm'
        }
        default:
          return 'LoginForm'
      }
    },
  },
  methods: {
    close() {
      this.$store.commit('modals/SET_MODAL', {
        currentModal: '',
      })
    },

    beforeOpen() {
      document.documentElement.style.overflowY = 'hidden'
    },

    beforeClose() {
      document.documentElement.style.overflowY = 'auto'
    },
  },
}
</script>

<style lang="scss">
.vm-backdrop {
  background: rgba(0, 0, 0, 0.15);
}
.AuthModal {
  display: flex;
  align-items: center;
  text-align: center;
  .vm {
    top: auto;
    max-width: 550px;
  }

  &__wrap {
    background-color: #f2f2f2;
    padding: 70px 70px;

    @include mobile {
      padding: 50px 30px;
    }

    @include xmobile {
      padding: 50px 15px;
    }
  }

  &__close {
    position: absolute;
    top: 20px;
    right: 20px;
    padding: 0;
  }

  &__title {
    margin-bottom: 10px;
    font-weight: bold;
    font-size: 18px;
    line-height: 21px;
    text-align: center;
    letter-spacing: 0.14em;
    text-transform: uppercase;
    @include xmobile {
      br {
        display: none;
      }
    }

    @include retina {
      font-size: 14px;
      line-height: 16px;
    }
  }

  &__subtitle {
    margin-bottom: 10px;
    font-weight: bold;
    font-size: 18px;
    line-height: 21px;
    text-align: center;
    letter-spacing: 0.14em;
    text-transform: uppercase;
    color: #4854af;
    @include xmobile {
      br {
        display: none;
      }
    }
    @include retina {
      font-size: 14px;
      line-height: 16px;
    }
  }

  &__text {
    font-family: $PTMono;
    font-size: 16px;
    line-height: 18px;
    color: #b0b0b0;
    @include xmobile {
      br {
        display: none;
      }
    }
  }

  &__form {
    max-width: 320px;
    margin: 35px auto 0;

    @include xmobile {
      max-width: 100%;
    }
  }
}
</style>
