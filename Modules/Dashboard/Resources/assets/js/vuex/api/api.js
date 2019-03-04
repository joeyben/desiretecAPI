export default {
  loadUser (success, error) {
    return window.axios.get(window.laroute.route('admin.access.users.current')).then(
      (response) => success(response.data),
      (response) => error(response)
    )
  },
  loadBackendAnalytics (success, error) {
    return window.axios.get(window.laroute.route('admin.dashboard.analytics')).then(
      (response) => success(response),
      (response) => error(response)
    )
  },
  loadWhitelabels (success, error) {
    return window.axios.get(window.laroute.route('admin.whitelabels.view')).then(
      (response) => success(response.data),
      (response) => error(response)
    )
  },
  loadLanguages (success, error) {
    return window.axios.get(window.laroute.route('languages')).then(
      (response) => success(response.data),
      (response) => error(response)
    )
  }
}
