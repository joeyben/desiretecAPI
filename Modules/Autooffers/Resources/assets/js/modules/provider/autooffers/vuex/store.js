import * as actions from './actions'
import * as getters from './getters'

const state = {
  users: {},
  checked: [],
  autooffer: {},
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
  ADD_AUTOOFFER (state, autooffer) {
    state.autooffer = autooffer
  },
  ADD_WHITELABELS (state, whitelabels) {
    state.whitelabels = whitelabels
  },
  LOAD_AUTOSETTING (state, autooffer) {
    state.autooffer = autooffer
  },
  updateAutooffer (state, obj) {
    state.autooffer[obj.name] = obj.value
  }
}

export default {
  state,
  getters,
  actions,
  mutations
}
