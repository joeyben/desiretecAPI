import * as actions from './actions'
import * as getters from './getters'

const state = {
  group: {},
  languageline: {},
  users: {},
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
  ADD_LANGUAGELINE (state, languageline) {
    state.languageline = languageline
  },
  ADD_WHITELABELS (state, whitelabels) {
    state.whitelabels = whitelabels
  },
  updateGroup (state, obj) {
    state.group[obj.name] = obj.value
  },
  updateLanguageLine (state, obj) {
    state.languageline[obj.name] = obj.value
  }
}

export default {
  state,
  getters,
  actions,
  mutations
}
