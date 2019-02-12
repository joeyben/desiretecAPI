import * as actions from './actions'
import * as getters from './getters'

const state = {
  notification: {},
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
  ADD_NOTIFICATION (state, notification) {
    state.notification = notification
  },
  ADD_WHITELABELS (state, whitelabels) {
    state.whitelabels = whitelabels
  },
  updateNotification (state, obj) {
    state.notification[obj.name] = obj.value
  }
}

export default {
  state,
  getters,
  actions,
  mutations
}
