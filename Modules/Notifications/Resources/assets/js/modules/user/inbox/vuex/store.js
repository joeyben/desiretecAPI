import * as actions from './actions'
import * as getters from './getters'

const state = {
  inbox: {},
  checked: []
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
  ADD_INBOX (state, inbox) {
    state.inbox = inbox
  },
  updateInbox (state, obj) {
    state.inbox[obj.name] = obj.value
  }
}

export default {
  state,
  getters,
  actions,
  mutations
}
