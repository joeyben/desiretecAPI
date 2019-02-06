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
    if (state.whitelabel[obj.type.replace('whitelabels/', '')].length <= 0) {
      state.whitelabel[obj.type.replace('whitelabels/', '')].push({name: obj.id, status: 'success', uid: obj.id, url: obj.url})
    }
  },
  removeWhitelabelFile (state, obj) {
    let background = state.whitelabel['background'].findIndex((c) => c.uid === obj.id)
    if (background >= 0) {
      state.whitelabel['background'].splice(background, 1)
    }

    let logo = state.whitelabel['logo'].findIndex((c) => c.uid === obj.id)
    if (logo >= 0) {
      state.whitelabel['logo'].splice(logo, 1)
    }

    let favicon = state.whitelabel['favicon'].findIndex((c) => c.uid === obj.id)
    if (favicon >= 0) {
      state.whitelabel['favicon'].splice(favicon, 1)
    }
  }
}

export default {
  state,
  getters,
  actions,
  mutations
}
