import * as types from '../../../../vuex/mutation-types'
import api from '../../../../vuex/api/api'

export const loadAutoSetting = function (store, whitelabelId) {
  api.loadAutoSetting(whitelabelId, response => {
    if (!response) {
      console.log('error', response)
      return
    }

    store.commit('LOAD_AUTOSETTING', response.autooffer)
  }, error => {
    console.log('LOAD_AUTOSETTING not answer', error)
  })
}

export const addAutooffer = function (store, autooffer) {
  store.commit(types.ADD_AUTOOFFER, autooffer)
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
