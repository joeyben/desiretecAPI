<template>
    <!-- Large modal -->
    <div v-if="response" id="chart-component"  style="height: 200px;min-width: 310px;max-width: 573px;max-height: 200px;">
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
  export default {
    name: 'TileResponsemComponent',
    components: { highcharts: Chart },
    data () {
      return {
        // eslint-disable-next-line
        response:1,
        errors: new Errors(),
        data: [],
        updateArgs: [true, true, {duration: 1000}],
        chartOptions: {
          chart: {
            type: 'line'
          },
          title: {
            text: this.trans('dashboard.monthly_mobile_response')
          },
          subtitle: {
            text: this.trans('dashboard.source_2019')
          },
          xAxis: {
            type: 'datetime',
            title: {
              text: this.trans('dashboard.date')
            }
          },
          yAxis: {
            title: {
              text: this.trans('dashboard.response')
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
            name: this.trans('dashboard.response'),
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
      this.loadMobileByMonth()
      this.$events.$on('whitelabel-set', (whitelabelId, start, end) => this.loadMobileByMonth(whitelabelId, start, end))
      this.$events.$on('range-date-set', (whitelabelId, start, end) => this.loadMobileByMonth(whitelabelId, start, end))
      this.$events.$on('response-set', response => this.loadResponse(response))
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
      loadMobileByMonth: function (whitelabelId = null, start = '', end = '') {
        let params = whitelabelId ? '?whitelabelId=' + whitelabelId : ''
        let paramsdate = whitelabelId ? '&start=' + start + '&end=' + end : '?start=' + start + '&end=' + end
        this.$store.dispatch('block', {element: 'dashboardComponent', load: true})
        this.$http.get(window.laroute.route('admin.dashboard.events.responsemMonth') + params + paramsdate)
          .then(this.onLoadDashboardSellerSuccess)
          .catch(this.onFailed)
          .then(() => {
            this.$store.dispatch('block', {element: 'dashboardComponent', load: false})
          })
      },
      loadResponse: function () {
        if (this.response === 1) {
          this.response = 0
        } else {
          this.response = 1
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
          this.response = response.data.response
          this.chartOptions.series[0].data = this.generateData(response.data.ga)
          this.data = response.data
        } else {
          this.$notify.error({ title: 'Failed', message: response.data.message })
        }
      }
    }
  }
</script>
