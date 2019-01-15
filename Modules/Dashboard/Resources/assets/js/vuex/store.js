import Vue from 'vue'
import Vuex from 'vuex'
import * as actions from './actions'
import * as getters from './getters'
import dashboard from '../modules/provider/dashboard/vuex/store'

Vue.use(Vuex)

const debug = process.env.NODE_ENV !== 'production'

const state = {
  currentUser: [],
  backendAnalytics: {}
}

const mutations = {
  LOGIN_USER (state, user) {
    state.currentUser = user
  },
  BACKEND_ANALYTICS (state, analytics) {
    state.backendAnalytics = analytics
    console.log(state.backendAnalytics)
  }
}

export default new Vuex.Store({
  getters,
  actions,
  state,
  mutations,
  modules: {
    dashboard
  },
  strict: debug
})
