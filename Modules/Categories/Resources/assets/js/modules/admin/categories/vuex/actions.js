import * as types from '../../../../vuex/mutation-types'

export const addCategory = function (store, category) {
  store.commit(types.ADD_ADMIN_CATEGORY, category)
}
