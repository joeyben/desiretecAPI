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
                <a href="#" @click="onExport()" class="export nav-item m-2" v-bind:class="{ active: filtered}"><i class="icon-file-text3"></i> Export
                    <span class="tooltiptext">Bitte wählen Sie den Zeitraum</span>
                </a>
                <span class="navbar-text font-weight-semibold mr-3">
                    Filter:
                </span>

                <ul class="navbar-nav flex-wrap">
                    <li class="nav-item m-1" v-if="hasRole('Administrator')">
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
                    <div>
                    <li class="m-1">
                      <el-date-picker style="width: 100%;"
                                        v-model="created"
                                        @input="doRange"
                                        type="daterange"
                                        start-placeholder="Start"
                                        end-placeholder="End">
                        </el-date-picker>
                    </li>
                  </div>
                  <li class="nav-item m-1">
                      <el-checkbox-button label="Basis" key="basis" @change="doBasis" v-model="basis">Basis</el-checkbox-button>
                      <el-checkbox-button label="Wünsche" key="wünsche" @change="doWunsch" v-model="wunsch">Wünsche</el-checkbox-button>
                      <el-checkbox-button label="LI Desktop" key="lidesktop" @change="doLiDesktop" v-model="lidesktop">LI Desktop</el-checkbox-button>
                      <el-checkbox-button label="LI Mobile" key="limobile" @change="doLiMobile" v-model="limobile">LI Mobile</el-checkbox-button>
                      <el-checkbox-button label="Desktop Browser" key="browser" @change="doBrowser" v-model="browser">Desktop Browser</el-checkbox-button>
                      <el-checkbox-button label="Response Rate" key="response" @change="doResponse" v-model="response">Response Rate</el-checkbox-button>
                      <el-checkbox-button label="E-Mail" key="email" @change="doEmail" v-model="email">E-Mail</el-checkbox-button>
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
  import TileClickrateComponent from './TileClickrateComponent'
  import TileClickrateautoComponent from './TileClickrateautoComponent'
  import TileOpenrateComponent from './TileOpenrateComponent'
  import TileOpenrateautoComponent from './TileOpenrateautoComponent'
  import TileMobileComponent from './TileMobileComponent'
  import TileMobiledComponent from './TileMobiledComponent'
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
  import TileShareComponent from './TileShareComponent'
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
      TileClickrateComponent,
      TileClickrateautoComponent,
      TileOpenrateComponent,
      TileOpenrateautoComponent,
      TileMobileComponent,
      TileMobiledComponent,
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
      TileShareComponent,
      GaDatatableComponent,
      BackendAnalyticsComponent
    },
    data () {
      return {
        urlExport: window.laroute.route('admin.dashboard.export'),
        created: '',
        filtered: false,
        whitelabelId: null,
        basis: 1,
        wunsch: 1,
        lidesktop: 1,
        limobile: 1,
        browser: 1,
        response: 1,
        email: 1,
        dashboards: []
      }
    },
    mounted () {
      this.loadUser()
      this.loadLayout()
      this.loadWhitelabels()
      this.$events.$on('whitelabel-set', (whitelabelId, start, end) => this.onExportW(whitelabelId, start, end))
      this.$events.$on('range-date-set', (whitelabelId, start, end) => this.onExportW(whitelabelId, start, end))
    },
    watch: {
    },
    computed: {
      ...Vuex.mapGetters({
        user: 'currentUser',
        whitelabels: 'whitelabels'
      }),
      can_filter () {
        return this.hasRole('Executive')
      }
    },
    methods: {
      ...Vuex.mapActions({
        loadUser: 'loadLoggedUser',
        loadWhitelabels: 'loadWhitelabels'
      }),
      onExport () {
        if (this.filtered === true) {
          window.location.href = this.urlExport
        }
      },
      onExportW: function (whitelabelId = null, start = '', end = '') {
        let params = whitelabelId ? '?whitelabelId=' + whitelabelId : ''
        let paramsdate = whitelabelId ? '&start=' + start + '&end=' + end : '?start=' + start + '&end=' + end
        this.$http.get(window.laroute.route('admin.dashboard.exportw') + params + paramsdate)
          .catch(this.onFailed)
          .then(() => {
            this.$store.dispatch('block', {element: 'dashboardComponent', load: false})
          })
      },
      doWhitelabel () {
        this.filtered = true
        this.$events.fire('whitelabel-set', this.whitelabelId)
      },
      doLiDesktop (e) {
        this.$events.fire('lidesktop-set', e)
        this.loadLayout()
      },
      doLiMobile (e) {
        this.$events.fire('limobile-set', e)
        this.loadLayout()
      },
      doBasis (e) {
        this.$events.fire('basis-set', e)
      },
      doWunsch (e) {
        this.$events.fire('wunsch-set', e)
        this.loadLayout()
      },
      doBrowser (e) {
        this.$events.fire('browser-set', e)
        this.loadLayout()
      },
      doResponse (e) {
        this.$events.fire('response-set', e)
        this.loadLayout()
      },
      doEmail (e) {
        this.$events.fire('email-set', e)
        this.loadLayout()
      },
      doRange (e) {
        this.filtered = true
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
          response.data.basis === 1 ? this.basis = true : this.basis = false
          response.data.wunsch === 1 ? this.wunsch = true : this.wunsch = false
          response.data.lidesktop === 1 ? this.lidesktop = true : this.lidesktop = false
          response.data.limobile === 1 ? this.limobile = true : this.limobile = false
          response.data.browser === 1 ? this.browser = true : this.browser = false
          response.data.response === 1 ? this.response = true : this.response = false
          response.data.email === 1 ? this.email = true : this.email = false
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
    a.export{
        cursor: default;
        color: grey;
    }
    a.export.active{
        cursor: pointer;
        color:#2196f3;
    }
    a.export.active:hover .tooltiptext{
        visibility: hidden;
    }
    a.export:hover .tooltiptext{
        visibility: visible;
    }
    .tooltiptext {
        visibility: hidden;
        background-color: #2196f3;
        color: #fff;
        font-weight:bold;
        top: 45px;
        left: 10px;
        padding: 5px 5px 5px;
        text-align: center;
        border-radius: 6px;

        /* Position the tooltip */
        position: absolute;
        z-index: 1;
    }
</style>
