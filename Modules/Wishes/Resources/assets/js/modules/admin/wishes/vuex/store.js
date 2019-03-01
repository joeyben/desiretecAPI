import * as actions from './actions'
import * as getters from './getters'

const state = {
  wish: {},
  checked: [],
  whitelabels: {}
}

const mutations = {
  REMOVE_CHECKED_ID (state, id) {
    let index = state.checked.findIndex((c) => c === id)
    state.checked.splice(index, 1)
  },
  ADD_CHECKED_ID (state, id) {
    state.checked.push(id)
  },
  ADD_CHECKED (state, checked) {
    state.checked = checked
  },
  ADD_GROUP (state, group) {
    state.group = group
  },
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
