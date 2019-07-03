<template>
    <!-- Large modal -->
    <div v-if="wunsch" id="chart-component"  style="height: 200px;min-width: 310px;max-width: 573px;max-height: 200px;">
        <highcharts class="chart" :options="chartOptions" :updateArgs="updateArgs"></highcharts>
    </div>
    <!-- /large modal -->
</template>
<script>
  import Vuex from 'vuex'
  import {Chart} from 'highcharts-vue'
  import Highcharts from 'highcharts'
  import exportingInit from 'highcharts/modules/exporting'
  import { Errors } from '../../../../../../../../../resources/assets/js/utils/errors'
  exportingInit(Highcharts)
  export default {
    name: 'ChartWishComponent',
    components: { highcharts: Chart },
    data () {
      return {
        // eslint-disable-next-line
        wunsch: 1,
        errors: new Errors(),
        data: [],
        updateArgs: [true, true, {duration: 1000}],
        chartOptions: {
          chart: {
            type: 'line'
          },
          title: {
            text: this.trans('dashboard.monthly_average_wish')
          },
          subtitle: {
            text: this.trans('dashboard.source_2019')
          },
          xAxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
          },
          yAxis: {
            title: {
              text: this.trans('dashboard.wishes')
            }
          },
          plotOptions: {
            line: {
              dataLabels: {
                enabled: true
              }
            }
          },

          series: [{
            name: this.trans('dashboard.wishes'),
            data: []
          }],

          responsive: {
            rules: [{
              condition: {
                maxWidth: 573,
                maxHeight: 200
              },
              chartOptions: {
                legend: {
                  align: 'center',
                  verticalAlign: 'bottom',
                  layout: 'horizontal'
                }
              }
            }]
          }
        }
      }
    },
    mounted () {
      this.loadWishByMonth()
      this.$events.$on('whitelabel-set', whitelabelId => this.loadWishByMonth(whitelabelId))
      this.$events.$on('wunsch-set', wunsch => this.loadWunsch(wunsch))
    },
    updated () {
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
      loadWishByMonth: function (whitelabelId = null) {
        let params = whitelabelId ? '?whitelabelId=' + whitelabelId : ''
        this.$store.dispatch('block', {element: 'dashboardComponent', load: true})
        this.$http.get(window.laroute.route('admin.dashboard.wishes.byMonth') + params)
          .then(this.onLoadDashboardSellerSuccess)
          .catch(this.onFailed)
          .then(() => {
            this.$store.dispatch('block', {element: 'dashboardComponent', load: false})
          })
      },
      loadWunsch: function () {
        if (this.wunsch === 1) {
          this.wunsch = 0
          this.$http.put(window.laroute.route('admin.event.save'), {shown: this.wunsch, id: 2})
        } else {
          this.wunsch = 1
          this.$http.put(window.laroute.route('admin.event.save'), {shown: this.wunsch, id: 2})
        }
      },
      onLoadDashboardSellerSuccess (response) {
        if (response.data.hasOwnProperty('success') && response.data.success === true) {
          this.wunsch = response.data.wunsch
          this.chartOptions.series[0].data = response.data.data
          this.data = response.data
        } else {
          this.$notify.error({ title: 'Failed', message: response.data.message })
        }
      }
    }
  }
</script>
