export default {
  loadWhitelabels (success, error) {
    return window.axios.get(window.laroute.route('provider.languages.view')).then(
      (response) => console.log(response.data),
      (response) => error(response)
    )
  },

  loadLocales (success, error) {
    return window.axios.get(window.laroute.route('provider.languages.view')).then(
      (response) => success(response.data),
      (response) => error(response)
    )
  }
}
