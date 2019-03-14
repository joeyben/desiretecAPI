export default {
  loadMissingLanguages (success, error) {
    return window.axios.get(window.laroute.route('provider.languages.missing')).then(
      (response) => success(response.data),
      (response) => error(response)
    )
  }
}
