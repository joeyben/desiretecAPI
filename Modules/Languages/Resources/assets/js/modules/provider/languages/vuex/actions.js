import * as types from '../../../../vuex/mutation-types'
import api from './api/api'

export const addLanguage = function (store, language) {
  store.commit(types.ADD_LANGUAGE, language)
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

export const loadMissingLanguages = function (store) {
  api.loadMissingLanguages(response => {
    if (!response) {
      console.log('error', response)
      return
    }

    store.commit(types.ADD_MISSING_LANGUAGES, response.missingLanguages)
  }, error => {
    console.log('LOGIN_USER not answer', error)
  })
}
