<template>
    <!-- Large modal -->
    <div id="chart-component"  style="height: 200px;min-width: 310px;max-width: 573px;max-height: 200px;">
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
        errors: new Errors(),
        data: [],
        updateArgs: [true, true, {duration: 1000}],
        chartOptions: {
          chart: {
            type: 'line'
          },
          title: {
            text: 'Daily Average Wish'
          },
          subtitle: {
            text: 'Current Month'
          },
          xAxis: {
            type: 'datetime',
            dateTimeLabelFormats: { // don't display the dummy year
              month: '%e. %b',
              year: '%b'
            },
            title: {
              text: 'Date'
            }
          },
          yAxis: {
            title: {
              text: 'Wish'
            }
          },
          plotOptions: {
            line: {
              dataLabels: {
                enabled: true
              },
              enableMouseTracking: false
            }
          },

          series: [{
            name: 'Wishes',
            data: [
              [Date.UTC(1970, 10, 25), 0],
              [Date.UTC(1970, 11, 6), 0.25],
              [Date.UTC(1970, 11, 20), 1.41],
              [Date.UTC(1970, 11, 25), 1.64],
              [Date.UTC(1971, 0, 4), 1.6],
              [Date.UTC(1971, 0, 17), 2.55],
              [Date.UTC(1971, 0, 24), 2.62],
              [Date.UTC(1971, 1, 4), 2.5],
              [Date.UTC(1971, 1, 14), 2.42],
              [Date.UTC(1971, 2, 6), 2.74],
              [Date.UTC(1971, 2, 14), 2.62],
              [Date.UTC(1971, 2, 24), 2.6],
              [Date.UTC(1971, 3, 1), 2.81],
              [Date.UTC(1971, 3, 11), 2.63],
              [Date.UTC(1971, 3, 27), 2.77],
              [Date.UTC(1971, 4, 4), 2.68],
              [Date.UTC(1971, 4, 9), 2.56],
              [Date.UTC(1971, 4, 14), 2.39],
              [Date.UTC(1971, 4, 19), 2.3],
              [Date.UTC(1971, 5, 4), 2],
              [Date.UTC(1971, 5, 9), 1.85],
              [Date.UTC(1971, 5, 14), 1.49],
              [Date.UTC(1971, 5, 19), 1.27],
              [Date.UTC(1971, 5, 24), 0.99],
              [Date.UTC(1971, 5, 29), 0.67],
              [Date.UTC(1971, 6, 3), 0.18],
              [Date.UTC(1971, 6, 4), 0]
            ]
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
        this.$http.get(window.laroute.route('admin.dashboard.wishes.byDay') + params)
          .then(this.onLoadDashboardSellerSuccess)
          .catch(this.onFailed)
          .then(() => {
            this.$store.dispatch('block', {element: 'dashboardComponent', load: false})
          })
      },
      onLoadDashboardSellerSuccess (response) {
        if (response.data.hasOwnProperty('success') && response.data.success === true) {
          // this.chartOptions.series[0].data = response.data.data
        } else {
          this.$notify.error({ title: 'Failed', message: response.data.message })
        }
      }
    }
  }
</script>
