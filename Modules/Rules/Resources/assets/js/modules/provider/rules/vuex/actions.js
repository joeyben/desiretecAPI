import * as types from '../../../../vuex/mutation-types'

export const addRule = function (store, rule) {
  store.commit(types.ADD_RULE, rule)
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
