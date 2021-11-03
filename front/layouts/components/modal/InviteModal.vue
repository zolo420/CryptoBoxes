<template>
  <client-only>
    <VueModal
      :based-on="visible"
      wrapper-class="animate__animated InviteModal"
      modal-class="InviteModal__wrap"
      in-class="animate__fadeInDown"
      out-class="animate__fadeOutDown"
      :base-zindex="9999"
      @close="close"
      @before-open="beforeOpen"
      @before-close="beforeClose"
    >
      <template #titlebar>
        <button class="InviteModal__close" type="button" @click="close">
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
        <div class="InviteModal__title">
          Чтобы увидеть результат, <br />
          авторизируйся и купи билет.
        </div>
        <div class="InviteModal__subtitle">
          В стоимость билета включено 12 попыток.
        </div>
        <div class="InviteModal__text">
          80% от стоимости билета идёт на пополнение кошелька.
        </div>
        <form class="InviteModal__form" novalidate @submit.prevent="submit">
          <div class="form__group">
            <span :style="{ color: error ? 'red' : 'black' }">{{
              message
            }}</span>
          </div>
          <div class="form__group">
            <field
              v-model="email"
              placeholder="Email друга"
              type="email"
              :text-error="
                ($v.email.$dirty && !$v.email.required
                  ? 'Поле не заполнено'
                  : '') ||
                ($v.email.$dirty && !$v.email.email
                  ? 'Не корректный email'
                  : '')
              "
            />
          </div>
          <div class="InviteModal__btn">
            <Button fluid type="button" @click="sendInvitation">
              Пригласить</Button
            >
          </div>
        </form>
        <div class="InviteModal__small">
          Стоимость билета увеличивается пропорционально увеличению баланса
          кошелька. Имеет смысл сразу купить несколько билетов, которые, кстати,
          можно будет перепродать на внутренней бирже.
        </div>
      </template>
    </VueModal>
  </client-only>
</template>

<script>
import { required, email } from 'vuelidate/lib/validators'
import { validationMixin } from 'vuelidate'
import Field from '@/components/form/Field'
import Button from '@/components/Button/Button'

export default {
  name: 'InviteModal',
  components: {
    Button,
    Field,
  },
  mixins: [validationMixin],
  data() {
    return {
      name: 'invite',
      email: '',
      message: '',
      error: false,
    }
  },

  validations: {
    email: {
      required,
      email,
    },
  },
  computed: {
    visible() {
      return !!(this.name === this.$store.state.modals.currentModal)
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

    sendInvitation() {
      this.$axios
        .post('/profile/send-invitation', {
          email: this.email,
        })
        .then(() => {
          this.message = 'Приглашение успешно отправлено'
        })
        .catch(() => {
          this.message = 'Ошибка отправки приглашения'
          this.error = true
        })
    },
  },
}
</script>

<style lang="scss">
.vm-backdrop {
  background: rgba(0, 0, 0, 0.15);
}

.InviteModal {
  display: flex;
  align-items: center;
  text-align: center;

  .vm {
    top: auto;
    max-width: 730px;
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

  &__small {
    font-family: $PTMono;
    font-size: 14px;
    line-height: 16px;
    text-align: center;
    margin-top: 70px;

    @include widescreen {
      margin-top: 50px;
    }

    @include tablet {
      margin-top: 30px;
    }
  }
}
</style>
