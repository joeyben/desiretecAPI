export default {
  loadUser (success, error) {
    return window.axios.get(window.laroute.route('admin.access.users.current')).then(
      (response) => success(response.data),
      (response) => error(response)
    )
  }
}
