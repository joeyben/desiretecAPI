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
    name: 'TileChartComponent',
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
            text: 'Monthly Average Wish'
          },
          subtitle: {
            text: 'Source: 2019'
          },
          xAxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
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
      loadWishByMonth: function () {
        this.$store.dispatch('block', {element: 'dashboardComponent', load: true})
        this.$http.get(window.laroute.route('admin.dashboard.wishes.byMonth'))
          .then(this.onLoadDashboardSellerSuccess)
          .catch(this.onFailed)
          .then(() => {
            this.$store.dispatch('block', {element: 'dashboardComponent', load: false})
          })
      },
      onLoadDashboardSellerSuccess (response) {
        if (response.data.hasOwnProperty('success') && response.data.success === true) {
          this.chartOptions.series[0].data = response.data.data
          this.data = response.data
        } else {
          this.$notify.error({ title: 'Failed', message: response.data.message })
        }
      }
    }
  }
</script>
