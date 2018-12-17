import * as types from '../../../../vuex/mutation-types'
import api from './api/api'

export const addGroup = function (store, group) {
  store.commit(types.ADD_GROUP, group)
}

export const loadWhitelabels = function (store) {
  api.loadWhitelabels(response => {
    if (!response) {
      console.log('error', response)
      return
    }

    store.commit(types.ADD_WHITELABELS, response.whitelabels)
  }, error => {
    console.log('LOGIN_USER not answer', error)
  })
}
