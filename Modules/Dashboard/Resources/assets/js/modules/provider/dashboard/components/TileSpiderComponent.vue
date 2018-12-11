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
  require('highcharts/highcharts-more')(Highcharts)
  exportingInit(Highcharts)
  export default {
    name: 'TileSpiderComponent',
    components: { highcharts: Chart },
    data () {
      return {
        // eslint-disable-next-line
        errors: new Errors(),
        updateArgs: [true, true, {duration: 1000}],
        chartOptions: {
          chart: {
            polar: true,
            type: 'line'
          },

          title: {
            text: 'Budget vs spending',
            x: -80
          },

          pane: {
            size: '80%'
          },

          xAxis: {
            categories: ['Sales', 'Marketing', 'Development', 'Customer Support',
              'Information Technology', 'Administration'],
            tickmarkPlacement: 'on',
            lineWidth: 0
          },

          yAxis: {
            gridLineInterpolation: 'polygon',
            lineWidth: 0,
            min: 0
          },

          tooltip: {
            shared: true,
            // eslint-disable-next-line
            pointFormat: '<span style="color:{series.color}">{series.name}: <b>${point.y:,.0f}</b><br/>'
          },

          legend: {
            align: 'right',
            verticalAlign: 'top',
            y: 70,
            layout: 'vertical'
          },

          series: [{
            name: 'Allocated Budget',
            data: [43000, 19000, 60000, 35000, 17000, 10000],
            pointPlacement: 'on'
          }, {
            name: 'Actual Spending',
            data: [50000, 39000, 42000, 31000, 26000, 14000],
            pointPlacement: 'on'
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
