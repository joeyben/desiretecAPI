import * as types from '../../../../vuex/mutation-types'

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
