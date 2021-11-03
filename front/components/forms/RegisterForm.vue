<template>
  <form class="RegisterForm" novalidate @submit.prevent="submit">
    <div class="form__group">
      <span style="color: red">{{ error }}</span>
    </div>
    <div class="form__group">
      <field
        v-model="user.name"
        placeholder="Имя пользователя"
        :text-error="
          $v.user.name.$dirty && !$v.user.name.required
            ? 'Поле не заполнено'
            : ''
        "
      />
    </div>
    <div class="form__group">
      <field
        v-model="user.email"
        placeholder="Email"
        :text-error="
          $v.user.email.$dirty && !$v.user.email.required
            ? 'Поле не заполнено'
            : ''
        "
      />
    </div>
    <div class="form__group">
      <field
        v-model="user.password"
        type="password"
        placeholder="Пароль"
        is-icon
        :text-error="
          $v.user.password.$dirty && !$v.user.password.required
            ? 'Поле не заполнено'
            : ''
        "
      />
    </div>
    <div class="form__group form__group--medium">
      <field
        v-model="user.password_confirm"
        type="password"
        placeholder="Повторить пароль"
        is-icon
        :text-error="
          $v.user.password_confirm.$dirty && !$v.user.password_confirm.required
            ? 'Поле не заполнено'
            : ''
        "
      />
    </div>
    <div class="form__group RegisterForm__text">
      Нажимая кнопку “Зарегистрироваться” вы даете согласие на обработку
      <a href="#" class="RegisterForm__link"> персональных данных </a>
    </div>
    <div class="RegisterForm__btn">
      <Button
        fluid
        type="button"
        outline
        dark
        class="LoginForm__submit"
        @click="$emit('change-form', 1)"
      >
        Войти
      </Button>
      <Button fluid type="submit"> Зарегистрироваться </Button>
    </div>
  </form>
</template>

<script>
import { required } from 'vuelidate/lib/validators'
import { validationMixin } from 'vuelidate'
import Button from '../Button/Button'
import Field from '../form/Field'
export default {
  name: 'RegisterForm',
  components: { Button, Field },
  mixins: [validationMixin],
  data() {
    return {
      user: {
        name: '',
        password: '',
        password_confirm: '',
        email: '',
      },
      error: '',
    }
  },
  validations: {
    user: {
      name: {
        required,
      },
      password: {
        required,
      },
      password_confirm: {
        required,
      },
      email: {
        required,
      },
    },
  },
  methods: {
    submit() {
      this.$v.$touch()
      if (this.$v.$invalid) {
        console.log('ERROR')
      } else {
        this.$axios
          .post('/auth/registration', {
            email: this.user.email,
            name: this.user.name,
            password: this.user.password,
            confirm_password: this.user.password_confirm,
          })
          .then((res) => {
            location.reload()
          })
          .catch((err) => {
            if (err.response.status === 422) {
              this.error = 'Пользователь с таким email уже существует'
            }
          })
      }
    },
  },
}
</script>

<style lang="scss">
.RegisterForm {
  text-align: left;
  &__btn {
    display: flex;
    justify-content: space-between;
  }
  &__submit {
    margin-right: 30px;
    @include xmobile {
      margin-right: 15px;
    }
  }

  &__text {
    font-size: 14px;
    line-height: 16px;
  }

  &__link {
    color: $red;
    transition: all 0.5s ease;
    &:hover {
      color: $gray;
    }
  }
}
</style>
