import * as actions from './actions'
import * as getters from './getters'

const state = {
  group: {},
  whitelabel: {},
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
  ADD_WHITELABEL (state, whitelabel) {
    state.whitelabel = whitelabel
  },
  ADD_WHITELABELS (state, whitelabels) {
    state.whitelabels = whitelabels
  },
  updateWhitelabel (state, obj) {
    state.whitelabel[obj.name] = obj.value
  },
  addWhitelabelFile (state, obj) {
    state.whitelabel[obj.name].push({name: obj.id, status: 'success', uid: obj.id, url: obj.url})
  },
  removeWhitelabelFile (state, obj) {
    let index = state.whitelabel[obj.name].findIndex((c) => c.uid === obj.id)
    state.whitelabel[obj.name].splice(index, 1)
  }
}

export default {
  state,
  getters,
  actions,
  mutations
}
