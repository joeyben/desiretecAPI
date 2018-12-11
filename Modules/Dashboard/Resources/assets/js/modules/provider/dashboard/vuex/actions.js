import * as types from '../../../../vuex/mutation-types'
import api from './api/api'

export const addPost = function (store, post) {
  store.commit(types.ADD_POST, post)
}

export const addCategories = function (store, categories) {
  store.commit(types.ADD_CATEGORIES, categories)
}

export const loadUsers = function (store) {
  api.loadUsers(response => {
    if (!response) {
      console.log('error', response)
      return
    }

    store.commit(types.ADD_USERS, response.users)
  }, error => {
    console.log('LOGIN_USER not answer', error)
  })
}
