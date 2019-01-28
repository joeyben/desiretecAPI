<template>
    <!-- Inner container -->
    <div>
        <grid-layout
                :layout.sync="dashboards"
                :col-num="12"
                :row-height="35"
                :is-draggable="true"
                :is-resizable="false"
                :is-mirrored="false"
                :vertical-compact="true"
                :margin="[20, 20]"
                :use-css-transforms="true"
                :responsive="true"
                :index="0"
        >

            <grid-item v-for="item in dashboards"
                       :x="item.x"
                       :y="item.y"
                       :w="item.w"
                       :h="item.h"
                       :i="item.i"
                       :key="item.i"
                       :class="{ datatable: item.component == 'ga-datatable-component' }"
                       @moved="movedEvent">
                <component :is="item.component" :key="item.i"></component>
            </grid-item>
        </grid-layout>
        <router-view></router-view>
    </div>
    <!-- /inner container -->
</template>

<script>
  import Vuex from 'vuex'
  import VueGridLayout from 'vue-grid-layout'
  import TileCommentComponent from './TileCommentComponent'
  import TileClickComponent from './TileClickComponent'
  import TileEventComponent from './TileEventComponent'
  import TileOrderComponent from './TileOrderComponent'
  import TileUserComponent from './TileUserComponent'
  import TileChartComponent from './TileChartComponent'
  import TilePieComponent from './TilePieComponent'
  import TileBarComponent from './TileBarComponent'
  import TileUpdateComponent from './TileUpdateComponent'
  import TileSpiderComponent from './TileSpiderComponent'
  import TileTdComponent from './TileTdComponent'
  import BackendAnalyticsComponent from './BackendAnalyticsComponent'
  import GaDatatableComponent from '../tables/ga/GaDatatableComponent'
export default {
    name: 'DashboardComponent',
    components: {
      GridLayout: VueGridLayout.GridLayout,
      GridItem: VueGridLayout.GridItem,
      TileCommentComponent,
      TileEventComponent,
      TileOrderComponent,
      TileUserComponent,
      TileChartComponent,
      TilePieComponent,
      TileBarComponent,
      TileSpiderComponent,
      TileUpdateComponent,
      TileTdComponent,
      TileClickComponent,
      GaDatatableComponent,
      BackendAnalyticsComponent
    },
    data () {
      return {
        dashboards: [],
        layout1: [
          {'x': 0, 'y': 0, 'w': 2, 'h': 2, 'i': '0', 'component': 'tile-comment-component'},
          {'x': 2, 'y': 0, 'w': 2, 'h': 2, 'i': '1', 'component': 'tile-click-component'},
          {'x': 4, 'y': 0, 'w': 2, 'h': 2, 'i': '2', 'component': 'tile-event-component'},
          {'x': 6, 'y': 0, 'w': 2, 'h': 2, 'i': '3', 'component': 'tile-user-component'},
          {'x': 8, 'y': 0, 'w': 2, 'h': 2, 'i': '4', 'component': 'tile-order-component'},
          {'x': 10, 'y': 0, 'w': 2, 'h': 2, 'i': '5', 'component': 'tile-comment-component'},
          {'x': 0, 'y': 2, 'w': 4, 'h': 8, 'i': '6', 'component': 'tile-update-component'},
          {'x': 4, 'y': 2, 'w': 4, 'h': 8, 'i': '7', 'component': 'tile-spider-component'},
          {'x': 8, 'y': 2, 'w': 4, 'h': 8, 'i': '9', 'component': 'tile-pie-component'},
          {'x': 0, 'y': 5, 'w': 4, 'h': 8, 'i': '11', 'component': 'tile-chart-component'},
          {'x': 4, 'y': 5, 'w': 4, 'h': 8, 'i': '12', 'component': 'tile-bar-component'},
          {'x': 8, 'y': 5, 'w': 4, 'h': 8, 'i': '13', 'component': 'tile-td-component'}
        ]
      }
    },
    mounted () {
      this.loadUser()
      this.loadLayout()
      this.loadWhitelabels()
    },
    watch: {
    },
    computed: {
      ...Vuex.mapGetters({
        user: 'currentUser'
      })
    },
    methods: {
      ...Vuex.mapActions({
        loadUser: 'loadLoggedUser',
        loadWhitelabels: 'loadWhitelabels'
      }),
      loadLayout: function () {
        this.$http.get(window.laroute.route('provider.dashboard.show'))
          .then(this.onLoadDashboardSuccess)
          .catch(this.onFailed)
          .then(() => {
            this.$store.dispatch('block', {element: 'dashboardComponent', load: false})
          })
      },
      movedEvent: function (i, newX, newY) {
        this.$http.put(window.laroute.route('provider.dashboard.save'), {dashboards: this.dashboards})
          .then(this.onSaveDashboardSuccess)
          .catch(this.onFailed)
          .then(() => {
            this.$store.dispatch('block', {element: 'dashboardComponent', load: false})
          })
      },
      onLoadDashboardSuccess (response) {
        if (response.data.hasOwnProperty('success') && response.data.success === true) {
          this.dashboards = response.data.dashboards
        } else {
          this.$notify.error({ title: 'Failed', message: response.data.message })
        }
      },
      onSaveDashboardSuccess (response) {
        if (response.data.hasOwnProperty('success') && response.data.success === true) {
        } else {
          this.$notify.error({ title: 'Failed', message: response.data.message })
        }
      },
      onFailed (error) {
        if (error.response !== undefined && error.response.hasOwnProperty('data') && error.response.data.hasOwnProperty('errors')) {
          this.errors.record(error.response.data.errors)
          if (error.response.data.hasOwnProperty('success') && error.response.data.hasOwnProperty('message')) {
            this.$notify.error({ title: 'Failed', message: error.response.data.message })
          } else {
            this.$notify.error({ title: 'Failed', dangerouslyUseHTMLString: true, message: this.errors.getErrors(this.errors.errors) })
          }
        } else if (error.response !== undefined && error.response.hasOwnProperty('data') && error.response.data.hasOwnProperty('message')) {
          this.$notify.error({ title: 'Failed', message: error.response.data.message })
        } else if (error.hasOwnProperty('message')) {
          this.$notify.error({ title: 'Error', message: error.message })
        } else {
          this.$notify.error({ title: 'Failed', message: 'Service not answer, Please contact your Support' })
          console.log(error)
        }
      }
    }
  }
</script>

<style>
    .datatable {
        overflow-y: auto;
    }
</style>
