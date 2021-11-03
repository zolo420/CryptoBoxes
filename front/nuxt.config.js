export default {
  head: {
    title: 'rob-run',
    htmlAttrs: {
      lang: 'en',
    },
    meta: [
      { charset: 'utf-8' },
      { name: 'viewport', content: 'width=device-width, initial-scale=1' },
      { hid: 'description', name: 'description', content: '' },
    ],
    link: [{ rel: 'icon', type: 'image/x-icon', href: '/favicon.ico' }],
  },

  css: [{ src: '@/assets/styles/app.scss', lang: 'scss' }],

  plugins: [
    { src: '@/plugins/vuelidate', ssr: false },
    { src: '@/plugins/vue-modal', ssr: false },
    { src: '@/plugins/vue-scrollactive', ssr: false },
    { src: '@/plugins/vue-kinesis', ssr: false },
    { src: '@/plugins/vue-animate-onscroll', ssr: false },
    { src: '@/plugins/axios_setup', ssr: false },
  ],

  components: true,

  buildModules: ['@nuxtjs/style-resources', '@nuxtjs/eslint-module'],

  modules: ['nuxt-breakpoints', '@nuxtjs/axios'],

  styleResources: {
    scss: ['~/assets/styles/global.scss'],
    hoistUseStatements: true,
  },

  axios: {
    baseURL: 'https://api.robrun.test/api',
  },

  build: {},
  ssr: false,
}
