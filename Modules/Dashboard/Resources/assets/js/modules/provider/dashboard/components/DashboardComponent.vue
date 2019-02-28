<template>
    <!-- Inner container -->
    <div>
        <!-- Filter toolbar -->
        <div class="navbar navbar-expand-lg navbar-light navbar-component rounded">
            <div class="text-center d-lg-none w-100">
                <button type="button" class="navbar-toggler dropdown-toggle" data-toggle="collapse" data-target="#navbar-filter">
                    <i class="icon-unfold mr-2"></i>
                    Filters
                </button>
            </div>

            <div class="navbar-collapse collapse" id="navbar-filter">
								<span class="navbar-text font-weight-semibold mr-3">
									Filter:
								</span>

                <ul class="navbar-nav flex-wrap">
                    <li class="nav-item dropdown">
                        <a href="#" class="navbar-nav-link dropdown-toggle" data-toggle="dropdown">
                            <i class="icon-sort mr-2"></i>
                            By Whitelabel
                        </a>

                        <div class="dropdown-menu">
                            <a href="#" class="dropdown-item">Show all</a>
                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item">Whitelabel 1</a>
                            <a href="#" class="dropdown-item">Whitelabel 2</a>
                            <a href="#" class="dropdown-item">Whitelabel 3</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <!-- /filter toolbar -->
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
  import TileWishComponent from './TileWishComponent'
  import TileGroupComponent from './TileGroupComponent'
  import TileSellerComponent from './TileSellerComponent'
  import TileCommentComponent from './TileCommentComponent'
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
      TileWishComponent,
      TileSellerComponent,
      TileCommentComponent,
      TileOrderComponent,
      TileUserComponent,
      TileChartComponent,
      TilePieComponent,
      TileBarComponent,
      TileSpiderComponent,
      TileUpdateComponent,
      TileTdComponent,
      TileGroupComponent,
      GaDatatableComponent,
      BackendAnalyticsComponent
    },
    data () {
      return {
        dashboards: []
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
        this.$http.get(window.laroute.route('admin.dashboard.show'))
          .then(this.onLoadDashboardSuccess)
          .catch(this.onFailed)
          .then(() => {
            this.$store.dispatch('block', {element: 'dashboardComponent', load: false})
          })
      },
      movedEvent: function (i, newX, newY) {
        this.$http.put(window.laroute.route('admin.dashboard.save'), {dashboards: this.dashboards})
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
