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
  require('highcharts/highcharts-3d')(Highcharts)
  exportingInit(Highcharts)
  export default {
    name: 'TileTdComponent',
    components: { highcharts: Chart },
    data () {
      return {
        // eslint-disable-next-line
        errors: new Errors(),
        updateArgs: [true, true, {duration: 1000}],
        chartOptions: {
          chart: {
            type: 'column',
            options3d: {
              enabled: true,
              alpha: 10,
              beta: 25,
              depth: 70
            }
          },
          title: {
            text: '3D chart with null values'
          },
          subtitle: {
            text: 'Notice the difference between a 0 value and a null point'
          },
          plotOptions: {
            column: {
              depth: 25
            }
          },
          xAxis: {
            categories: Highcharts.getOptions().lang.shortMonths,
            labels: {
              skew3d: true,
              style: {
                fontSize: '16px'
              }
            }
          },
          yAxis: {
            title: {
              text: null
            }
          },
          series: [{
            name: 'Sales',
            data: [2, 3, null, 4, 0, 5, 1, 4, 6, 3]
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
    },
    updated () {
      debugger
    },
    watch: {
    },
    computed: {
      ...Vuex.mapGetters({
      })
    },
    methods: {
      ...Vuex.mapActions({
      })
    }
  }
</script>
