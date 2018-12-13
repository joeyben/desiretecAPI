import * as types from '../../../../vuex/mutation-types'
import api from './api/api'

export const addWish = function (store, wish) {
  store.commit(types.ADD_WISH, wish)
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
