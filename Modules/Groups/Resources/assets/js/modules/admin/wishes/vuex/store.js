import * as actions from './actions'
import * as getters from './getters'

const state = {
  wish: {},
  whitelabels: {}
}

const mutations = {
  ADD_WISH (state, wish) {
    state.wish = wish
  },
  ADD_WHITELABELS (state, whitelabels) {
    state.whitelabels = whitelabels
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
