import * as types from '../../../../vuex/mutation-types'
import api from './api/api'

export const addWhitelabel = function (store, whitelabel) {
  store.commit(types.ADD_WHITELABEL, whitelabel)
}

export const addGroup = function (store, group) {
  store.commit(types.ADD_GROUP, group)
}

export const addCheckedId = function (store, id) {
  store.commit(types.ADD_CHECKED_ID, id)
}

export const removeCheckedId = function (store, id) {
  store.commit(types.REMOVE_CHECKED_ID, id)
}

export const addChecked = function (store, checked) {
  store.commit(types.ADD_CHECKED, checked)
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
