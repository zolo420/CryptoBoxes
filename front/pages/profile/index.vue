<template>
  <div class="user">
    <form class="user__group" @submit.prevent="save">
      <label class="form__label">Имя пользователя</label>
      <div class="form__group">
        <field
          v-model="user.name"
          placeholder="Изменить имя"
          :text-error="
            ($v.user.name.$dirty && !$v.user.name.required
              ? 'Поле не заполнено'
              : '') ||
            ($v.user.name.$dirty && !$v.user.name.minLength
              ? `Поле логин должено быть не менее ${$v.user.name.$params.minLength.min} символов`
              : null)
          "
        />
      </div>
      <div class="form__group">
        <field
          v-model="user.email"
          placeholder="Новая почта"
          type="email"
          :text-error="
            ($v.user.email.$dirty && !$v.user.email.required
              ? 'Поле не заполнено'
              : '') ||
            ($v.user.email.$dirty && !$v.user.email.email
              ? 'Не корректный email'
              : '')
          "
        />
      </div>
      <Button blue :medium="$breakpoints.width > 576" type="submit">
        Сохранить
      </Button>
    </form>

    <form
      v-if="isResetPassword"
      class="user__group"
      @submit.prevent="resetPassword"
    >
      <label class="form__label">Сброс пароля</label>
      <div class="form__group form__group--small">
        <field
          v-model="resetUserPassword.email"
          placeholder="Введите email"
          type="email"
          :text-error="
            ($v.resetUserPassword.email.$dirty &&
            !$v.resetUserPassword.email.required
              ? 'Поле не заполнено'
              : '') ||
            ($v.resetUserPassword.email.$dirty &&
            !$v.resetUserPassword.email.email
              ? 'Не корректный email'
              : '')
          "
        />
      </div>
      <div class="form__group">
        <a href="#" class="form__link" @click.prevent="isResetPassword = false">
          Вернуться назад
        </a>
      </div>
      <Button blue :medium="$breakpoints.width > 576" type="submit">
        Сбросить пароль
      </Button>
    </form>
    <form v-else class="user__group" @submit.prevent="changePassword">
      <label class="form__label">Пароль</label>
      <div class="form__group">
        <field
          v-model="userPassword.password_old"
          type="password"
          placeholder="Старый пароль"
        />
      </div>
      <div class="form__group">
        <field
          v-model="userPassword.password"
          type="password"
          placeholder="Новый пароль"
          is-icon
          :text-error="
            $v.userPassword.password.$dirty &&
            !$v.userPassword.password.minLength
              ? `Поле должно быть не менее ${$v.userPassword.password.$params.minLength.min} символов`
              : ''
          "
        />
      </div>
      <div class="form__group form__group--small">
        <field
          v-model="userPassword.password_confirm"
          type="password"
          placeholder="Повторить пароль"
          is-icon
          :text-error="
            $v.userPassword.password_confirm.$dirty && !$v.userPassword.sameAs
              ? `Пароли не совпадают`
              : ''
          "
        />
      </div>
      <div class="form__group">
        <a href="#" class="form__link" @click.prevent="isResetPassword = true"
          >Забыли пароль?</a
        >
      </div>
      <Button blue :medium="$breakpoints.width > 576" type="submit">
        Сменить пароль
      </Button>
    </form>
  </div>
</template>

<script>
import { required, email, minLength, sameAs } from 'vuelidate/lib/validators'
import { validationMixin } from 'vuelidate'
import Button from '~/components/Button/Button.vue'
import Field from '~/components/form/Field.vue'

export default {
  name: 'Profile',
  components: { Field, Button },
  mixins: [validationMixin],
  layout: 'profile',
  data() {
    return {
      isResetPassword: false,
      user: {
        name: '',
        email: '',
      },
      resetUserPassword: {
        email: '',
      },
      userPassword: {
        password: '',
        password_old: '',
        password_confirm: '',
      },
    }
  },
  validations: {
    userPassword: {
      password: {minLength: minLength(6)},
      password_confirm: {sameAsPassword: sameAs('password')},
    },

    user: {
      name: {
        required,
        minLength: minLength(4),
      },
      email: {
        required,
        email,
      },
    },

    resetUserPassword: {
      email: {
        required,
        email,
      },
    },

    validationGroup: ['userPassword', 'user', 'resetUserPassword'],
  },

  head() {
    return {
      title: 'Профиле',
    }
  },

  methods: {
    save() {
      this.$v.user.$touch()
      if (this.$v.$invalid) {
        console.log('ERROR')
      } else {
        console.log('PENDING')
        setTimeout(() => {
          console.log('OK', this.user)
        }, 500)
      }
    },
    changePassword() {
      this.$v.userPassword.$touch()
      if (this.$v.$invalid) {
        console.log('ERROR')
      } else {
        console.log('PENDING')
        setTimeout(() => {
          console.log('OK', this.userPassword)
        }, 500)
      }
    },

    resetPassword() {
      this.$v.resetUserPassword.$touch()
      if (this.$v.$invalid) {
        console.log('ERROR')
      } else {
        console.log('PENDING')
        setTimeout(() => {
          console.log('OK', this.resetUserPassword)
        }, 500)
      }
    },
  },
}
</script>

<style lang="scss">
.user {
  padding: 50px;
  display: flex;

  @include widescreen {
    padding: 30px 15px;
  }

  @include tablet {
    padding: 30px 0;
  }

  @include mobile {
    flex-direction: column;
  }

  &__group {
    max-width: 300px;
    width: 100%;
    margin-right: 30px;

    @include mobile {
      max-width: 100%;
      margin: 0 0 30px;
    }

    &:last-child {
      margin: 0;
    }
  }
}
</style>
