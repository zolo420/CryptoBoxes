export const state = () => ({
  token: process.client ? localStorage.getItem('token') || '' : null,
})

export const mutations = {
  SET_TOKEN(state, payload) {
    state.token = payload.token
    process.client && localStorage.setItem('token', payload.token)
    console.log(state)
  },
}

export const actions = {}
