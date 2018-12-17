import * as actions from './actions'
import * as getters from './getters'

const state = {
  group: {},
  users: {},
  whitelabels: {}
}

const mutations = {
  ADD_GROUP (state, group) {
    state.group = group
  },
  ADD_WHITELABELS (state, whitelabels) {
    state.whitelabels = whitelabels
  },
  updateGroup (state, obj) {
    state.group[obj.name] = obj.value
  }
}

export default {
  state,
  getters,
  actions,
  mutations
}
