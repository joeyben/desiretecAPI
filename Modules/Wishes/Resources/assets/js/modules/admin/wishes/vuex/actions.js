import * as types from '../../../../vuex/mutation-types'

export const addWish = function (store, wish) {
  store.commit(types.ADD_WISH, wish)
}
