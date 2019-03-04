<template>
    <!-- Large modal -->
    <div class="card card-body bg-teal-400 has-bg-image">
        <div class="media">
            <div class="media-body">
                <h3 class="mb-0" v-text="groupCount"></h3>
                <span class="text-uppercase font-size-xs">{{ trans('dashboard.total_groups') }}</span>
            </div>

            <div class="ml-3 align-self-center">
                <i class="icon-collaboration icon-3x opacity-75"></i>
            </div>
        </div>
    </div>
    <!-- /large modal -->
</template>
<script>
  import Vuex from 'vuex'
  import { Errors } from '../../../../../../../../../resources/assets/js/utils/errors'
  export default {
    name: 'TileGroupComponent',
    components: { },
    data () {
      return {
        // eslint-disable-next-line
        errors: new Errors(),
        groupCount: 0
      }
    },
    mounted () {
      this.loadGroup()
      this.$events.$on('whitelabel-set', whitelabelId => this.loadGroup(whitelabelId))
    },
    watch: {
    },
    computed: {
      ...Vuex.mapGetters({
      })
    },
    methods: {
      ...Vuex.mapActions({
      }),
      loadGroup: function (whitelabelId) {
        let params = whitelabelId ? '?whitelabelId=' + whitelabelId : ''
        this.$store.dispatch('block', {element: 'dashboardComponent', load: true})
        this.$http.get(window.laroute.route('admin.dashboard.groups') + params)
          .then(this.onLoadDashboardGroupSuccess)
          .catch(this.onFailed)
          .then(() => {
            this.$store.dispatch('block', {element: 'dashboardComponent', load: false})
          })
      },
      onLoadDashboardGroupSuccess (response) {
        if (response.data.hasOwnProperty('success') && response.data.success === true) {
          this.groupCount = response.data.groupCount
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
