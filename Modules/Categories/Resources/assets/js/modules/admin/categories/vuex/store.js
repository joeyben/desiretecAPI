import * as actions from './actions'
import * as getters from './getters'

const state = {
  category: []
}

const mutations = {
  ADD_ADMIN_CATEGORY (state, category) {
    state.category = category
  },
  updateCategory (state, obj) {
    if (obj.name.indexOf('.') > -1) {
      state.category[obj.name.split('.')[0]][obj.name.split('.')[1]] = obj.value
    } else {
      state.category[obj.name] = obj.value
    }
  }
}

export default {
  state,
  getters,
  actions,
  mutations
}
