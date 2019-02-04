<template>
    <!-- Inner container -->
    <div>
        <vue-datatable></vue-datatable>
        <router-view></router-view>
    </div>
    <!-- /inner container -->
</template>

<script>
  import Vuex from 'vuex'
  import VueDatatable from '../tables/users/VueDatatable'
  export default {
    name: 'UsersComponent',
    components: { VueDatatable },
    data () {
      return {
      }
    },
    mounted () {
      this.loadUser()
      this.loadWhitelabels()
    },
    watch: {
    },
    computed: {
      ...Vuex.mapGetters({
        currentUser: 'currentUser'
      })
    },
    methods: {
      ...Vuex.mapActions({
        loadUser: 'loadLoggedUser'
      }),
      loadWhitelabels () {
        if (this.hasRoleTo('Administrator')) {
          this.$store.dispatch('block', {element: 'usersComponent', load: true})
          this.$http.get(window.laroute.route('admin.whitelabels.view'))
            .then(this.onLoadUserSuccess)
            .catch(this.onFailed)
            .then(() => {
              this.$store.dispatch('block', {element: 'usersComponent', load: false})
            })
        }
      },
      hasRoleTo (role) {
        return this.currentUser.hasOwnProperty('roles') && this.currentUser.roles[role]
      },
      onLoadUserSuccess (response) {
        if (response.data.hasOwnProperty('success') && response.data.success === true) {
          this.$store.commit('ADD_WHITELABELS', response.data.whitelabels)
        } else {
          this.$notify.error({ title: 'Failed', message: response.data.message })
        }
      },
      onFailed (error) {
        if (error.response !== undefined && error.response.hasOwnProperty('data') && error.response.data.hasOwnProperty('errors')) {
          this.errors.record(error.response.data.errors)
          if (error.response.data.hasOwnProperty('success') && error.response.data.hasOwnProperty('message')) {
            this.$notify.error({ title: 'Failed', message: error.response.data.message })
          } else {
            this.$notify.error({ title: 'Failed', dangerouslyUseHTMLString: true, message: this.errors.getErrors(this.errors.errors) })
          }
        } else if (error.response !== undefined && error.response.hasOwnProperty('data') && error.response.data.hasOwnProperty('message')) {
          this.$notify.error({ title: 'Failed', message: error.response.data.message })
        } else if (error.hasOwnProperty('message')) {
          this.$notify.error({ title: 'Error', message: error.message })
        } else {
          this.$notify.error({ title: 'Failed', message: 'Service not answer, Please contact your Support' })
          console.log(error)
        }
      }
    }
  }
</script>
