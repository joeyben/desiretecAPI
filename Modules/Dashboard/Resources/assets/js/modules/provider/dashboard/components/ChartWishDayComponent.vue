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
  import moment from 'moment'
  exportingInit(Highcharts)
  moment.locale(window.i18.lang)
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
          legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle'
          },
          plotOptions: {
            line: {
              dataLabels: {
                enabled: true
              },
              chartOptions: {
                legend: {
                  layout: 'horizontal',
                  align: 'center',
                  verticalAlign: 'bottom'
                }
              }
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
      generateData (items) {
        let data = []
        items.forEach((item, index) => {
          data.push([moment(item[0], 'YYYY-MM-DD').utc(+1).valueOf(), item[1]])
        })
  
        return data
      },
      onLoadDashboardSellerSuccess (response) {
        if (response.data.hasOwnProperty('success') && response.data.success === true) {
          this.chartOptions.series[0].data = this.generateData(response.data.data)
        } else {
          this.$notify.error({ title: 'Failed', message: response.data.message })
        }
      }
    }
  }
</script>
