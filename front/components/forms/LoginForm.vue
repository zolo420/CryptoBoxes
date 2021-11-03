<template>
  <client-only>
    <form class="LoginForm" @submit.prevent="submit">
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
      <div class="form__group form__group--medium">
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
      <div class="form__group">
        <a href="#" class="LoginForm__link" @click="$emit('change-form', 3)">
          Забыли пароль?
        </a>
      </div>
      <div class="LoginForm__btn">
        <Button fluid type="submit" class="LoginForm__submit">Войти</Button>
        <Button
          fluid
          type="button"
          outline
          dark
          @click="$emit('change-form', 2)"
        >
          Регистрация
        </Button>
      </div>
    </form>
  </client-only>
</template>

<script>
import { required } from 'vuelidate/lib/validators'
import { validationMixin } from 'vuelidate'
import Button from '../Button/Button'
import Field from '../form/Field'

export default {
  name: 'LoginForm',
  components: { Button, Field },
  mixins: [validationMixin],
  data() {
    return {
      user: {
        name: '',
        password: '',
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
    },
  },
  methods: {
    submit() {
      this.$v.$touch()
      if (this.$v.$invalid) {
        // eslint-disable-next-line no-console
        console.log('ERROR')
      } else {
        // eslint-disable-next-line no-console
        this.$axios
          .post('/auth/login', {
            email: this.user.name,
            password: this.user.password,
            remember: 'on',
          })
          .then((res) => {
            const data = res.data
            this.$store.commit('auth/SET_TOKEN', { token: data.access_token })
            this.$store.commit('modals/SET_MODAL', {
              currentModal: '',
            })
            this.$router.push('/profile')
          })
          .catch((err) => {
            if (err.response.status === 422) {
              this.error = 'Пользователь ненайден'
            }
          })
      }
    },
  },
}
</script>

<style lang="scss">
.LoginForm {
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

  &__link {
    display: inline-flex;
    font-size: 14px;
    line-height: 16px;
    color: #000000;
  }
}
</style>
