<template>
    <!-- Inner container -->
    <div>
        <!-- Filter toolbar -->
        <div class="navbar navbar-expand-lg navbar-light navbar-component rounded" v-if="can_filter">
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
                    <li class="nav-item">
                        <el-select v-model="whitelabelId" placeholder="Please choose a Whitelabel" style="width: 100%;" @input="doWhitelabel">
                            <el-option
                                    v-for="item in whitelabels"
                                    :key="item.id"
                                    :label="item.name"
                                    :value="item.id">
                                <span style="float: left"><i :class="item.name"></i> {{ item.name }}</span>
                            </el-option>
                        </el-select>
                    </li>
                    <li>
                      <el-date-picker style="width: 100%;"
                                        v-model="created"
                                        @input="doRange"
                                        type="daterange"
                                        start-placeholder="Start"
                                        end-placeholder="End">
                        </el-date-picker>
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
  import moment from 'moment'
  import VueGridLayout from 'vue-grid-layout'
  import TileWishComponent from './TileWishComponent'
  import TileOfferComponent from './TileOfferComponent'
  import TileOfferdayComponent from './TileOfferdayComponent'
  import TileMobileComponent from './TileMobileComponent'
  import TileResponseComponent from './TileResponseComponent'
  import TileResponsemComponent from './TileResponsemComponent'
  import TileGroupComponent from './TileGroupComponent'
  import TileSellerComponent from './TileSellerComponent'
  import TileCommentComponent from './TileCommentComponent'
  import TileOrderComponent from './TileOrderComponent'
  import TileUserComponent from './TileUserComponent'
  import ChartWishDayComponent from './ChartWishDayComponent'
  import TilePieComponent from './TilePieComponent'
  import TileBarComponent from './TileBarComponent'
  import ChartWishComponent from './ChartWishComponent'
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
      TileOfferComponent,
      TileOfferdayComponent,
      TileMobileComponent,
      TileResponseComponent,
      TileResponsemComponent,
      TileSellerComponent,
      TileCommentComponent,
      TileOrderComponent,
      TileUserComponent,
      ChartWishDayComponent,
      TilePieComponent,
      TileBarComponent,
      TileSpiderComponent,
      ChartWishComponent,
      TileTdComponent,
      TileGroupComponent,
      GaDatatableComponent,
      BackendAnalyticsComponent
    },
    data () {
      return {
        created: '',
        whitelabelId: null,
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
        user: 'currentUser',
        whitelabels: 'whitelabels'
      }),
      can_filter () {
        return this.hasRole('Administrator')
      }
    },
    methods: {
      ...Vuex.mapActions({
        loadUser: 'loadLoggedUser',
        loadWhitelabels: 'loadWhitelabels'
      }),
      doWhitelabel () {
        this.$events.fire('whitelabel-set', this.whitelabelId)
      },
      doRange (e) {
        this.$events.fire('range-date-set', this.whitelabelId, moment(e[0], moment.ISO_8601).startOf('day').format('YYYY-MM-DD'), moment(e[1], moment.ISO_8601).endOf('day').format('YYYY-MM-DD '))
      },
      hasPermissionTo (permission) {
        return this.user.hasOwnProperty('permissions') && this.user.permissions[permission]
      },
      hasRole (permission) {
        return this.user.hasOwnProperty('roles') && this.user.roles[permission]
      },
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
