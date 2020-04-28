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
  import moment from 'moment'
  exportingInit(Highcharts)
  moment.locale(window.i18.lang)
  export default {
    name: 'ChartWishDayComponent',
    components: { highcharts: Chart },
    data () {
      return {
        // eslint-disable-next-line
        created: '',
        wunsch: 1,
        errors: new Errors(),
        data: [],
        updateArgs: [true, true, {duration: 1000}],
        chartOptions: {
          chart: {
            type: 'line'
          },
          title: {
            text: this.trans('dashboard.daily_average_wish')
          },
          xAxis: {
            type: 'datetime',
            dateTimeLabelFormats: { // don't display the dummy year
              month: '%e. %b',
              year: '%b'
            },
            title: {
              text: this.trans('dashboard.date')
            }
          },
          yAxis: {
            title: {
              text: this.trans('dashboard.wishes')
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
      this.$events.$on('whitelabel-set', (whitelabelId, start, end) => this.loadWishByMonth(whitelabelId, start, end))
      this.$events.$on('range-date-set', (whitelabelId, start, end) => this.loadWishByMonth(whitelabelId, start, end))
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
      loadWishByMonth: function (whitelabelId = null, start = '', end = '') {
        let params = whitelabelId ? '?whitelabelId=' + whitelabelId : ''
        let paramsdate = whitelabelId ? '&start=' + start + '&end=' + end : '?start=' + start + '&end=' + end
        this.$store.dispatch('block', {element: 'dashboardComponent', load: true})
        this.$http.get(window.laroute.route('admin.dashboard.events.wishesDay') + params + paramsdate)
          .then(this.onLoadDashboardSellerSuccess)
          .catch(this.onFailed)
          .then(() => {
            this.$store.dispatch('block', {element: 'dashboardComponent', load: false})
          })
      },
      loadWunsch: function () {
        if (this.wunsch === 1) {
          this.wunsch = 0
        } else {
          this.wunsch = 1
        }
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
          this.wunsch = response.data.wunsch
          this.chartOptions.series[0].data = this.generateData(response.data.wishesday)
        } else {
          this.$notify.error({ title: 'Failed', message: response.data.message })
        }
      }
    }
  }
</script>
