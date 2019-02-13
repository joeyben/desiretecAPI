import Vue from 'vue'
import Vuex from 'vuex'
import * as actions from './actions'
import * as getters from './getters'
import notifications from '../modules/user/notifications/vuex/store'
import inbox from '../modules/user/inbox/vuex/store'

Vue.use(Vuex)

const debug = process.env.NODE_ENV !== 'production'

const state = {
  currentUser: [],
  languages: []
}

const mutations = {
  LOGIN_USER (state, user) {
    state.currentUser = user
  },
  LOAD_LANGUAGES (state, languages) {
    state.languages = languages
  }
}

export default new Vuex.Store({
  getters,
  actions,
  state,
  mutations,
  modules: {
    inbox,
    notifications
  },
  strict: debug
})
