import * as actions from './actions'
import * as getters from './getters'

const state = {
  variant: {},
  users: {},
  checked: [],
  whitelabels: {}
}

const mutations = {
  REMOVE_CHECKED_ID (state, id) {
    let index = state.checked.findIndex((c) => c === id)
    state.checked.splice(index, 1)
  },
  ADD_CHECKED_ID (state, id) {
    state.checked.push(id)
  },
  ADD_CHECKED (state, checked) {
    state.checked = checked
  },
  ADD_VARIANT (state, variant) {
    state.variant = variant
  },
  ADD_WHITELABELS (state, whitelabels) {
    state.whitelabels = whitelabels
  },
  updateVariant (state, obj) {
    state.variant[obj.name] = obj.value
  },
  addVariantFile (state, obj) {
    let key = obj.type.replace('variants', '').slice(1)

    if (state.variant[key].length <= 0) {
      let index = state.variant[key].findIndex((c) => c.uid === obj.id)
      if (index < 0) {
        state.variant[key].push({name: obj.id, status: 'success', uid: obj.id, url: obj.url})
      }
    }
  },
  removeVariantFile (state, obj) {
    let visual = state.variant['visual'].findIndex((c) => c.uid === obj.id)
    if (visual >= 0) {
      state.variant['visual'].splice(visual, 1)
    }

    let logo = state.variant['logo'].findIndex((c) => c.uid === obj.id)
    if (logo >= 0) {
      state.variant['logo'].splice(logo, 1)
    }
  }
}

export default {
  state,
  getters,
  actions,
  mutations
}
