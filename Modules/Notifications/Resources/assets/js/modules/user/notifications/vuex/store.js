import * as actions from './actions'
import * as getters from './getters'

const state = {
  notifications: [],
  count: 0
}

const mutations = {
  ADD_NOTIFICATIONS (state, notifications) {
    state.notifications = notifications
  },
  ADD_NOTIFICATIONS_COUNT (state, count) {
    state.count = count
  },
  ADD_NOTIFICATION (state, notification) {
    state.notifications.unshift(notification)
    state.count++
  }
}

export default {
  state,
  getters,
  actions,
  mutations
}
