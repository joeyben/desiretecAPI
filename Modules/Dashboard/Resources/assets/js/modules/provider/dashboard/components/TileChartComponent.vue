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
        updateArgs: [true, true, {duration: 1000}],
        chartOptions: {
          chart: {
            type: 'column'
          },

          title: {
            text: 'Highcharts responsive chart'
          },

          subtitle: {
            text: 'Resize the frame to see the legend position change'
          },

          legend: {
            align: 'right',
            verticalAlign: 'middle',
            layout: 'vertical'
          },

          xAxis: {
            categories: ['Apples', 'Oranges', 'Bananas']
          },

          yAxis: {
            title: {
              text: 'Amount'
            }
          },

          series: [{
            name: 'Christmas Eve',
            data: [1, 4, 3]
          }, {
            name: 'Christmas Day before dinner',
            data: [6, 4, 2]
          }, {
            name: 'Christmas Day after dinner',
            data: [8, 4, 3]
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
