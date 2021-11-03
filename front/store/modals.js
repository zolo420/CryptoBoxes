export const state = () => ({
  currentModal: '',
  modalOptions: {},
})

export const mutations = {
  SET_MODAL(state, payload) {
    state.currentModal = payload.name
    state.modalOptions = payload
  },
  CLEAR_MODAL(state) {
    state.currentModal = false
    state.currentModal = ''
    state.modalOptions = {}
  },
}

export const actions = {
  openModal({ commit }, payload) {
    commit('SET_MODAL', payload)
  },
  closeModal({ commit }) {
    commit('CLEAR_MODAL')
  },
}
