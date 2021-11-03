export default function ({ $axios, store }) {
  $axios.onRequest((config) => {
    config.headers.common.Authorization = 'Bearer ' + store.state.auth.token
  })
}
