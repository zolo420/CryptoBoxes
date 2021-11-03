<template>
  <client-only>
    <scrollactive
      active-class="menu__link--active"
      class="menu"
      :scroll-on-start="false"
      @itemchanged="onItemChanged"
    >
      <ul class="menu__list" :class="[classList]">
        <li
          v-for="item in menuList"
          :key="item.id"
          class="menu__item"
          :class="[classItem]"
        >
          <a
            v-if="item.isScroll"
            :href="item.path"
            class="menu__link scrollactive-item"
          >
            {{ item.title }}
          </a>
          <nuxt-link v-else class="menu__link" :to="item.path">
            {{ item.title }}
          </nuxt-link>
        </li>
      </ul>
    </scrollactive>
  </client-only>
</template>

<script>
export default {
  name: 'Menu',
  props: {
    classList: {
      type: String,
      default: '',
    },
    classItem: {
      type: String,
      default: '',
    },
  },
  data() {
    return {
      menuList: [
        { id: 1, title: 'HARD BOXES', path: '/#hard', isScroll: true },
        { id: 2, title: 'EASY BOXES', path: '/#easy', isScroll: true },
        { id: 3, title: 'QUEST BOXES', path: '/#quest', isScroll: true },
        { id: 4, title: 'БАЛАНС', path: '/profile/balance' },
      ],
    }
  },
  methods: {
    onItemChanged() {
      // console.log(event, currentItem, lastActiveItem)
      // here you have access to everything you need regarding that event
      this.$emit('change-menu')
    },
  },
}
</script>

<style lang="scss">
.menu {
  &__list {
    display: flex;
    align-items: center;
  }

  &__item {
    margin-right: 40px;

    &:last-child {
      margin: 0;
    }
  }

  &__link {
    font-family: $PTMono;
    font-style: normal;
    font-weight: normal;
    font-size: 15px;
    line-height: 17px;
    color: $black;

    &--active,
    &:hover {
      color: $blue;
    }
  }
}
</style>
