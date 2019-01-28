export default {
  loadUsers (success, error) {
    return window.axios.get(window.laroute.route('admin.lists.users')).then(
      (response) => success(response.data),
      (response) => error(response)
    )
  },
  loadWhitelabels (success, error) {
    return window.axios.get(window.laroute.route('admin.whitelabels.view')).then(
      (response) => success(response.data),
      (response) => error(response)
    )
  }
}
