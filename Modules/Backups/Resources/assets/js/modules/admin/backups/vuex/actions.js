import api from './api/api'

export const loadLoggedUser = function (store) {
  api.loadUser(response => {
    if (!response) {
      console.log('error', response)
      return
    }

    store.commit('LOGIN_USER', response.user)
  }, error => {
    console.log('LOGIN_USER not answer', error)
  })
}
