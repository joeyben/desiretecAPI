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
    name: 'TilePieComponent',
    components: { highcharts: Chart },
    data () {
      return {
        // eslint-disable-next-line
        errors: new Errors(),
        updateArgs: [true, true, {duration: 1000}],
        chartOptions: {
          title: {
            text: 'Combination chart'
          },
          xAxis: {
            categories: ['Apples', 'Oranges', 'Pears', 'Bananas', 'Plums']
          },
          labels: {
            items: [{
              html: 'Total fruit consumption',
              style: {
                left: '50px',
                top: '18px',
                color: (Highcharts.theme && Highcharts.theme.textColor) || 'black'
              }
            }]
          },
          series: [{
            type: 'column',
            name: 'Jane',
            data: [3, 2, 1, 3, 4]
          }, {
            type: 'column',
            name: 'John',
            data: [2, 3, 5, 7, 6]
          }, {
            type: 'column',
            name: 'Joe',
            data: [4, 3, 3, 9, 0]
          }, {
            type: 'spline',
            name: 'Average',
            data: [3, 2.67, 3, 6.33, 3.33],
            marker: {
              lineWidth: 2,
              lineColor: Highcharts.getOptions().colors[3],
              fillColor: 'white'
            }
          }, {
            type: 'pie',
            name: 'Total consumption',
            data: [{
              name: 'Jane',
              y: 13,
              color: Highcharts.getOptions().colors[0] // Jane's color
            }, {
              name: 'John',
              y: 23,
              color: Highcharts.getOptions().colors[1] // John's color
            }, {
              name: 'Joe',
              y: 19,
              color: Highcharts.getOptions().colors[2] // Joe's color
            }],
            center: [100, 80],
            size: 100,
            showInLegend: false,
            dataLabels: {
              enabled: false
            }
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
