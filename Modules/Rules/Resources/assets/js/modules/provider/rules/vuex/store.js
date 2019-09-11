import * as actions from './actions'
import * as getters from './getters'

const state = {
  rule: {},
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
  ADD_RULE (state, rule) {
    state.rule = rule
  },
  ADD_WHITELABELS (state, whitelabels) {
    state.whitelabels = whitelabels
  },
  updateRuleRemoveDestination (state, destination) {
    state.rule['destination'].splice(state.rule['destination'].indexOf(destination), 1)
  },
  updateRuleDestination (state, obj) {
    let index = state.rule['destination'].indexOf(obj.value)
    if (index === -1) {
      state.rule['destination'].push(obj.value)
    }
  },
  updateRule (state, obj) {
    state.rule[obj.name] = obj.value
  }
}

export default {
  state,
  getters,
  actions,
  mutations
}
