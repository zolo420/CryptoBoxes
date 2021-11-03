<template>
  <form class="ResetForm" novalidate @submit.prevent="submit">
    <div class="form__group">
      <span>{{ this.message }}</span>
    </div>
    <div class="form__group">
      <field
        v-model="email"
        placeholder="Введите email"
        type="email"
        :text-error="
          ($v.email.$dirty && !$v.email.required ? 'Поле не заполнено' : '') ||
          ($v.email.$dirty && !$v.email.email ? 'Не корректный email' : '')
        "
      />
    </div>

    <div class="ResetForm__btn">
      <Button fluid type="submit" class="ResetForm__submit">
        Сбосить пароль
      </Button>
      <Button fluid type="button" outline dark @click="$emit('change-form', 1)">
        Войти
      </Button>
    </div>
  </form>
</template>

<script>
import { required, email } from 'vuelidate/lib/validators'
import { validationMixin } from 'vuelidate'
import Button from '../Button/Button'
import Field from '../form/Field'
export default {
  name: 'ResetForm',
  components: { Button, Field },
  mixins: [validationMixin],
  data() {
    return {
      email: '',
      message: '',
    }
  },
  validations: {
    email: {
      required,
      email,
    },
  },
  methods: {
    submit() {
      this.$v.$touch()
      if (this.$v.$invalid) {
        console.log('ERROR')
      } else {
        this.$axios
          .post('/auth/forgot-password', {
            email: this.email,
          })
          .finally(() => {
            this.message = 'Инструкция отправлена на почту'
          })
      }
    },
  },
}
</script>

<style lang="scss">
.ResetForm {
  text-align: left;
  &__btn {
    display: flex;
    justify-content: space-between;
  }
  &__submit {
    white-space: nowrap;
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
