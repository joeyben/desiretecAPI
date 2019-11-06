export default {
  loadWhitelabels (success, error) {
    return window.axios.get(window.laroute.route('admin.whitelabels.view')).then(
      (response) => success(response.data),
      (response) => error(response)
    )
  },
  loadCurrentWhitelabel (success, error) {
    return window.axios.get(window.laroute.route('admin.whitelabels.current')).then(
      (response) => success(response.data),
      (response) => error(response)
    )
  },
  loadWhitelabel (id, success, error) {
    return window.axios.get(window.laroute.route('admin.whitelabels.show', {id: id})).then(
      (response) => success(response.data),
      (response) => error(response)
    )
  }
}
