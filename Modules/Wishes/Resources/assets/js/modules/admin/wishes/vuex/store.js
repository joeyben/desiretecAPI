import * as actions from './actions'
import * as getters from './getters'

const state = {
  wish: {}
}

const mutations = {
  ADD_WISH (state, wish) {
    state.wish = wish
  },
  updateWish (state, obj) {
    state.wish[obj.name] = obj.value
  }
}

export default {
  state,
  getters,
  actions,
  mutations
}
