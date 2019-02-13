export default {
  loadNotifications (success, error) {
    return window.axios.get(window.laroute.route('notifications.view')).then(
      (response) => success(response.data),
      (response) => error(response)
    )
  }
}
