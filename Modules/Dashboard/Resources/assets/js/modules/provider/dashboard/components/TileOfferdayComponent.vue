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
    name: 'TileOfferComponent',
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
            text: this.trans('Ereignisse pro Tag')
          },
          subtitle: {
            text: this.trans('dashboard.source_2019')
          },
          xAxis: {
  
          },
          yAxis: {
            title: {
              text: this.trans('Ereignisse')
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
            name: this.trans('Ereignisse'),
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
      this.loadOfferByDay()
      this.$events.$on('whitelabel-set', whitelabelId => this.loadOfferByDay(whitelabelId))
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
      loadOfferByDay: function (whitelabelId = null) {
        let params = whitelabelId ? '?whitelabelId=' + whitelabelId : ''
        this.$store.dispatch('block', {element: 'dashboardComponent', load: true})
        this.$http.get(window.laroute.route('admin.dashboard.events.perDay') + params)
          .then(this.onLoadDashboardSellerSuccess)
          .catch(this.onFailed)
          .then(() => {
            this.$store.dispatch('block', {element: 'dashboardComponent', load: false})
          })
      },
      onLoadDashboardSellerSuccess (response) {
        if (response.data.hasOwnProperty('success') && response.data.success === true) {
          this.chartOptions.series[0].data = response.data.ga
          this.data = response.data
        } else {
          this.$notify.error({ title: 'Failed', message: response.data.message })
        }
      }
    }
  }
</script>
