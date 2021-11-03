<template>
  <div v-if="invite" class="invite">
    <div class="invite__left">
      <div class="invite__email">{{ invite.email }}</div>
      <div class="invite__date">{{ invite.dateTime }}</div>
    </div>
    <div class="invite__right">
      <div class="invite__status" :style="{ color: invite.status.color }">
        {{ invite.status.name }}
      </div>
      <a
        href="#"
        :disabled="invite.status.disabled || isClipboardText"
        class="invite__link"
        @click.prevent="clipboard(invite.link)"
      >
        {{
          isClipboardText ? 'Скопировано' : 'Скопировать ссылку для приглашения'
        }}
      </a>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Invite',
  props: {
    invite: {
      type: Object,
      default: null,
      require: true,
    },
  },

  data() {
    return {
      isClipboardText: false,
    }
  },

  watch: {
    isClipboardText(val) {
      if (val) {
        setTimeout(() => {
          this.isClipboardText = false
        }, 3000)
      }
    },
  },

  methods: {
    clipboard(link) {
      navigator.clipboard.writeText(location.host + link)
      this.isClipboardText = true
    },
  },
}
</script>

<style lang="scss" scoped>
.invite {
  background-color: $white;
  box-shadow: 10px 10px 30px rgba(0, 0, 0, 0.07);
  padding: 30px;
  margin-bottom: 10px;
  display: flex;
  justify-content: space-between;

  &:last-child {
    margin: 0;
  }

  @include mobile {
    flex-direction: column;
    padding: 30px 15px;
  }

  &__left {
  }

  &__email {
    font-weight: bold;
    font-size: 20px;
    line-height: 23px;
    letter-spacing: 0.14em;
    margin-bottom: 20px;

    @include desktop {
      font-size: 18px;
      line-height: 20px;
      letter-spacing: 1px;
    }

    @include tablet {
      font-size: 16px;
      line-height: 18px;
    }

    @include mobile {
      margin-bottom: 10px;
    }
  }
  &__date {
    font-family: $PTMono;
    font-size: 14px;
    line-height: 16px;
    letter-spacing: 0.14em;
    color: #b0b0b0;
    @include widescreen {
      letter-spacing: 1px;
    }
  }

  &__right {
    text-align: right;

    @include mobile {
      text-align: left;
      margin-top: 10px;
    }
  }
  &__status {
    font-family: $PTMono;
    font-size: 14px;
    line-height: 16px;
    letter-spacing: 0.14em;
    margin-bottom: 20px;

    @include widescreen {
      letter-spacing: 1px;
    }
  }

  &__link {
    font-size: 12px;
    line-height: 14px;
    color: #4854af;

    &[disabled] {
      color: #b0b0b0;
      pointer-events: none;
      @include mobile {
        border: 1px solid #b0b0b0;
      }
    }

    @include mobile {
      display: flex;
      align-items: center;
      justify-content: center;
      text-align: center;
      width: 100%;
      min-height: 48px;
      border: 1px solid #4854af;
    }
  }
}
</style>
