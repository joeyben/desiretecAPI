export default {
  loadUsers (success, error) {
    return window.axios.get(window.laroute.route('admin.lists.users')).then(
      (response) => success(response.data),
      (response) => error(response)
    )
  }
}
