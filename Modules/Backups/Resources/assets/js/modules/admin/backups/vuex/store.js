import * as actions from './actions'
import * as getters from './getters'

const state = {
  post: {},
  users: [],
  categories: []
}

const mutations = {
  ADD_POST (state, post) {
    state.post = post
  },
  ADD_USERS (state, users) {
    state.users = users
  },
  ADD_CATEGORIES (state, categories) {
    state.categories = categories
  },
  updatePost (state, obj) {
    if (obj.name.indexOf('.') > -1) {
      state.post[obj.name.split('.')[0]][obj.name.split('.')[1]] = obj.value
    } else {
      state.post[obj.name] = obj.value
    }
  },
  updatePostTags (state, obj) {
    let index = state.post['tags'].indexOf(obj.value)
    if (index === -1) {
      state.post['tags'].push(obj.value)
    }
  },
  updatePostRemoveTags (state, tag) {
    state.post['tags'].splice(state.post['tags'].indexOf(tag), 1)
  }
}

export default {
  state,
  getters,
  actions,
  mutations
}
