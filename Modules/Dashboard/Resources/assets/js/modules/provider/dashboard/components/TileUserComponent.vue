<template>
    <!-- Large modal -->
    <div v-if="basis" class="card card-body bg-purple-400 has-bg-image">
        <div class="media">
            <div class="media-body text-left">
                <h3 class="mb-0" v-text="reactionTimeByMonth"></h3>
                <span class="text-uppercase font-size-xs">{{ trans('dashboard.reaction_time_average_month') }}</span>
            </div>

            <div class="media-body text-right">
                <h3 class="mb-0" v-text="reactionTimeByDay"></h3>
                <span class="text-uppercase font-size-xs">{{ trans('dashboard.reaction_time_average_day') }}</span>
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
        basis: 1,
        errors: new Errors(),
        reactionTimeByMonth: 0,
        reactionTimeByDay: 0
      }
    },
    mounted () {
      this.loadReationTimeByMonth()
      this.loadReationTimeByDay()
      this.$events.$on('whitelabel-set', whitelabelId => this.loadReationTimeByMonth(whitelabelId))
      this.$events.$on('basis-set', basis => this.loadBasis(basis))
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
      loadReationTimeByMonth: function (whitelabelId) {
        let params = whitelabelId ? '?whitelabelId=' + whitelabelId : ''
        this.$store.dispatch('block', {element: 'dashboardComponent', load: true})
        this.$http.get(window.laroute.route('admin.dashboard.timeByMonth') + params)
          .then(this.onLoadDashboardReationTimeByMonthSuccess)
          .catch(this.onFailed)
          .then(() => {
            this.$store.dispatch('block', {element: 'dashboardComponent', load: false})
          })
      },
      loadBasis: function () {
        if (this.basis === 1) {
          this.basis = 0
        } else {
          this.basis = 1
        }
      },
      loadReationTimeByDay: function (whitelabelId) {
        let params = whitelabelId ? '?whitelabelId=' + whitelabelId : ''
        this.$store.dispatch('block', {element: 'dashboardComponent', load: true})
        this.$http.get(window.laroute.route('admin.dashboard.timeByDay') + params)
          .then(this.onLoadDashboardReationTimeByDaySuccess)
          .catch(this.onFailed)
          .then(() => {
            this.$store.dispatch('block', {element: 'dashboardComponent', load: false})
          })
      },
      onLoadDashboardReationTimeByMonthSuccess (response) {
        if (response.data.hasOwnProperty('success') && response.data.success === true) {
          this.basis = response.data.basis
          this.reactionTimeByMonth = response.data.reactionTime
        } else {
          this.$notify.error({ title: 'Failed', message: response.data.message })
        }
      },
      onLoadDashboardReationTimeByDaySuccess (response) {
        if (response.data.hasOwnProperty('success') && response.data.success === true) {
          this.reactionTimeByDay = response.data.reactionTime
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
