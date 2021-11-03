<template>
  <client-only>
    <svg v-bind="$attrs" :viewBox="viewBox" :width="width" :height="height" />
  </client-only>
</template>

<script>
import { parse } from 'postsvg'
import render from 'posthtml-render'

// Кэш загруженных иконок
const cache = new Map()

export default {
  name: 'BaseSVGIcon',
  props: {
    // Имя файла (без расширения)
    iconName: {
      type: String,
      required: true,
    },

    // Ширина
    width: {
      type: [Number, String],
      default: 20,
    },

    // Высота
    height: {
      type: [Number, String],
      default: 20,
    },

    // Цвет заливки
    fill: {
      type: String,
      default: '',
    },

    // Цвет обводки
    stroke: {
      type: String,
      default: '',
    },

    // Генерировать ли событие ready иконки
    generateReadyEvent: {
      type: Boolean,
      default: false,
    },
  },
  data() {
    return {
      // Строка с содержимым SVG-файла
      svgString: '',
    }
  },
  computed: {
    // Путь расположения SVG-файла
    // eslint-disable next line
    filepath() {
      return require(`~/assets/icons/${this.iconName}.svg`)
    },

    // Распарсенное дерево SVG-файла
    parsedSVG() {
      return this.svgString ? parse(this.svgString) : null
    },

    // Размер холста
    viewBox() {
      return this.parsedSVG ? this.parsedSVG.root.attrs.viewBox : '0 0 20 20'
    },
  },
  watch: {
    // При изменении файла, перезагружаем его
    filepath: {
      immediate: true,
      handler: 'loadFile',
    },

    // При загрузке другого файла обновляем SVG
    svgString: 'refreshSvg',

    // При изменениях стилизации обновляем SVG
    stroke: 'refreshSvg',
    fill: 'refreshSvg',
  },
  methods: {
    // Загрузка содержимого SVG файла
    loadFile() {
      this.getSvgIconText().then(
        (responseText) => (this.svgString = responseText)
      )
      // .then((responseText) => (this.svgString = responseText))
      // eslint-disable-next-line no-console
      // .catch((error) => {
      // eslint-disable-next-line no-console
      // console.error('Ошибка загрузки SVG-файла', error)
      // })
    },

    // Получение SVG-файла в виде текстовой строки
    // + кэширование ранее загруженных файлов
    async getSvgIconText() {
      const url = this.filepath

      // Кэшируем загружаемые иконки
      // для сокращения запросов к серверу
      if (!cache.has(url)) {
        try {
          cache.set(
            url,
            fetch(url).then((r) => r.text())
          )
        } catch (e) {
          cache.delete(url)
        }
      }

      // Возвращаем содержимое из кэша
      return cache.has(url)
        ? await cache.get(url)
        : Promise.reject(new Error('Нет SVG-файла в локальном кэше'))
    },

    // Обновление SVG
    refreshSvg() {
      Promise.resolve(this.parsedSVG)
        // Обновляем стилизацию
        .then((svgTree) => {
          svgTree.each('path', (node) =>
            this.fill ? (node.attrs.fill = this.fill) : ''
          )
          // (node.attrs.fill = this.fill)
          return svgTree
        })
        // Оставляем только внутренности тега <svg>
        .then((svgTree) => render(svgTree.root.content))
        // Заменяем содержимое тега <svg> новым
        .then((svgHtml) => (this.$el.innerHTML = svgHtml))
        .then(() => this.generateReadyEvent && this.$emit('ready'))
        .catch((error) => {
          // eslint-disable-next-line no-console
          // console.error('Ошибка при обновлении SVG', error)
          this.$emit('error', error)
        })
    },
  },
}
</script>
