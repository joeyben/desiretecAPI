import * as actions from './actions'
import * as getters from './getters'

const state = {
  language: {},
  users: {},
  checked: [],
  whitelabels: {},
  missingLanguages: {}
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
  ADD_LANGUAGE (state, language) {
    state.language = language
  },
  ADD_WHITELABELS (state, whitelabels) {
    state.whitelabels = whitelabels
  },
  ADD_MISSING_LANGUAGES (state, missingLanguages) {
    state.missingLanguages = missingLanguages
  },
  updateLanguage (state, obj) {
    state.language[obj.name] = obj.value
  }
}

export default {
  state,
  getters,
  actions,
  mutations
}
