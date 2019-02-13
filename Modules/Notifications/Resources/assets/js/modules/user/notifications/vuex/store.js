import * as actions from './actions'
import * as getters from './getters'

const state = {
  notifications: []
}

const mutations = {
  ADD_NOTIFICATIONS (state, notifications) {
    state.notifications = notifications
  },
  ADD_NOTIFICATION (state, notification) {
    state.notifications.unshift(notification)
  }
}

export default {
  state,
  getters,
  actions,
  mutations
}
