import * as types from '../../../../vuex/mutation-types'
import api from './api/api'
// import Echo from 'laravel-echo'

export const loadNotifications = function (store) {
  api.loadNotifications(response => {
    if (!response) {
      console.log('error', response)
      return
    }
    store.commit(types.ADD_NOTIFICATIONS, response.notifications['data'])
    store.commit(types.ADD_NOTIFICATIONS_COUNT, response.notifications['total'])
    // window.e = new Echo({
    //   broadcaster: 'socket.io',
    //   host: window.location.hostname === 'localhost' ? window.location.hostname + ':6001' : window.location.hostname
    // })
    //
    // window.e.private(`App.User.${response.userId}`)
    //   .notification((notification) => {
    //     store.commit(types.ADD_NOTIFICATION, {id: notification.id, from: notification.from, message: notification.message, created_at: notification.created_at})
    //   })
  }, error => {
    console.log('LOGIN_USER not answer', error)
  })
}
