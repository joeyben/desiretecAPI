
<script>
  import Vue from 'vue'
import Vuex from 'vuex'
import toastr from 'toastr'
import moment from 'moment'

import Vuetable from 'vuetable-2/src/components/Vuetable.vue'
import VuetablePagination from 'vuetable-2/src/components/VuetablePagination'
import VuetablePaginationInfo from 'vuetable-2/src/components/VuetablePaginationInfo'
import config from './config'
import FilterBar from './FilterBar'
import CssConfig from './CssConfig.js'

  Vue.component('filter-bar', FilterBar)
  Vue.component('my-detail-row', config.detail)
  Vue.component('custom-actions', config.actions)
  Vue.component('custom-link-by-id', config.customLinkById)
  Vue.component('custom-link-by-title', config.CustomLinkByTitle)
  Vue.component('custom-status', config.CustomStatus)
  Vue.component('custom-user', config.customUser)
  toastr.options.progressBar = true
  toastr.options.preventDuplicates = true
  moment.locale(window.i18.lang)

  export default {
    name: 'VueDatatable',
    props: {
    },
    data () {
      return {
        apiUrl: window.laroute.route('admin.components.view'),
        fields: config.fields,
        sortOrder: config.sortOrder,
        appendParams: config.moreParams,
        perPage: config.perPage,
        detailRowComponent: 'my-detail-row',
        rowClass: 'context',
        css: CssConfig,
        loading: false
      }
    },
    components: { Vuetable, VuetablePagination, VuetablePaginationInfo },
    mounted () {
      this.$events.$on('filter-set', eventData => this.onFilterSet(eventData))
      this.$events.$on('show-set', fields => this.onShowSet(fields))
      this.$events.$on('page-set', perPage => this.onPageSet(perPage))
      this.$events.$on('filter-reset', e => this.onFilterReset())
      this.$events.$on('view-set', (action, data, index) => this.doView(action, data, index))
      this.$events.$on('migrate-set', (name) => this.doMigrate(name))
      this.$events.$on('install-set', (name) => this.doInstall(name))
      this.$events.$on('uninstall-set', (name) => this.doUninstall(name))
    },
    render (h) {
      return h(
        'div',
        {
          class: { 'card': true }
        },
        [
          h('filter-bar'),
          this.renderCardBody(h),
          this.renderMain(h)
        ]
      )
    },
    methods: {
      ...Vuex.mapActions({
      }),
      refresh () {
        Vue.nextTick(() => this.$refs.vuetable.refresh())
      },
      onPageSet (perPage) {
        this.perPage = perPage
        Vue.nextTick(() => this.$refs.vuetable.refresh())
      },
      onFilterSet (filterText) {
        this.appendParams.filter = filterText
        Vue.nextTick(() => this.$refs.vuetable.refresh())
      },
      onShowSet (fields) {
        this.fields = fields
        Vue.nextTick(() => this.$refs.vuetable.normalizeFields(this.fields))
      },
      doUninstall (name) {
        window.bootbox.prompt({
          title: 'Uninstall component',
          inputType: 'checkbox',
          inputOptions: [
            {
              text: ' Keep Database Tables',
              value: '1'
            }
          ],
          buttons: {
            confirm: {
              label: '<i class="fa fa-check"></i> Ok',
              className: 'bg-teal-800'
            },
            cancel: {
              label: 'Cancel',
              className: 'btn-danger'
            }
          },
          callback: (result) => {
            if (Array.isArray(result) && result.includes('1')) {
              this.onUninstall(name, 1)
            } else if (Array.isArray(result)) {
              this.onUninstall(name, 0)
            }
          }
        })
      },
      onSeed (key) {
        this.$store.dispatch('block', {element: 'componentsComponent', load: true})
        this.$http.get(window.laroute.route('admin.components.seed', {key: key}))
          .then(this.onMigrateSuccess)
          .catch(this.onFailed)
          .then(() => {
            this.$store.dispatch('block', {element: 'componentsComponent', load: false})
          })
      },
      onMigrate (key) {
        this.$store.dispatch('block', {element: 'componentsComponent', load: true})
        this.$http.get(window.laroute.route('admin.components.migrate', {key: key}))
          .then(this.onMigrateSuccess)
          .catch(this.onFailed)
          .then(() => {
            this.$store.dispatch('block', {element: 'componentsComponent', load: false})
          })
      },
      onRefresh (key) {
        this.$store.dispatch('block', {element: 'componentsComponent', load: true})
        this.$http.get(window.laroute.route('admin.components.refresh', {key: key}))
          .then(this.onMigrateSuccess)
          .catch(this.onFailed)
          .then(() => {
            this.$store.dispatch('block', {element: 'componentsComponent', load: false})
          })
      },
      onRollBack (key) {
        this.$store.dispatch('block', {element: 'componentsComponent', load: true})
        this.$http.get(window.laroute.route('admin.components.rollback', {key: key}))
          .then(this.onMigrateSuccess)
          .catch(this.onFailed)
          .then(() => {
            this.$store.dispatch('block', {element: 'componentsComponent', load: false})
          })
      },
      onUninstall (key, keep) {
        this.$store.dispatch('block', {element: 'componentsComponent', load: true})
        this.$http.get(window.laroute.route('admin.components.uninstall', {key: key, keep: keep}))
          .then(this.onUninstallSuccess)
          .catch(this.onFailed)
          .then(() => {
            this.$store.dispatch('block', {element: 'componentsComponent', load: false})
          })
      },
      doInstall (name) {
        window.bootbox.confirm({
          title: 'Install component',
          message: 'Do you really want to install this component ?',
          buttons: {
            confirm: {
              label: '<i class="fa fa-check"></i> Ok',
              className: 'bg-teal-800'
            },
            cancel: {
              label: 'Cancel',
              className: 'btn-danger'
            }
          },
          callback: (result) => {
            if (result) {
              this.onInstall(name)
            }
          }
        })
      },
      onInstall (key) {
        this.$store.dispatch('block', {element: 'componentsComponent', load: true})
        this.$http.get(window.laroute.route('admin.components.install', {key: key}))
          .then(this.onInstallSuccess)
          .catch(this.onFailed)
          .then(() => {
            this.$store.dispatch('block', {element: 'componentsComponent', load: false})
          })
      },
      onInstallSuccess (response) {
        if (response.data.hasOwnProperty('success') && response.data.success === true) {
          this.$message({
            type: 'success',
            message: response.data.message
          })
          Vue.nextTick(() => this.$refs.vuetable.refresh())
        } else {
          toastr.error(response.data.message)
        }
      },
      doMigrate (name) {
        window.bootbox.prompt({
          title: 'Please select a database action',
          inputType: 'checkbox',
          inputOptions: [
            {
              text: ' Module:seed',
              value: '0'
            },
            {
              text: ' Module:migrate',
              value: '1'
            },
            {
              text: ' Module:migrate-refresh',
              value: '2'
            },
            {
              text: ' Module:migrate-rollback',
              value: '3'
            }
          ],
          buttons: {
            confirm: {
              label: '<i class="fa fa-check"></i> Ok',
              className: 'btn btn-outline btn-sm bg-teal text-teal-800 btn-icon ml-2'
            },
            cancel: {
              label: 'Cancel',
              className: 'btn btn-outline btn-sm bg-danger text-danger-800 btn-icon ml-2'
            }
          },
          callback: (result) => {
            if (Array.isArray(result) && result.includes('0')) {
              this.onSeed(name)
            } else if (Array.isArray(result) && result.includes('1')) {
              this.onMigrate(name)
            } else if (Array.isArray(result) && result.includes('2')) {
              this.onRefresh(name)
            } else if (Array.isArray(result) && result.includes('3')) {
              this.onRollBack(name)
            }
          }
        })
      },
      onMigrateSuccess (response) {
        if (response.data.hasOwnProperty('success') && response.data.success === true) {
          this.$message({
            type: 'success',
            message: response.data.message
          })
          Vue.nextTick(() => this.$refs.vuetable.refresh())
        } else {
          toastr.error(response.message)
        }
      },
      onFilterReset () {
        delete this.appendParams.filter
        delete this.appendParams.start
        delete this.appendParams.end
        delete this.appendParams.whitelabel
        Vue.nextTick(() => this.$refs.vuetable.refresh())
      },
      renderLoader (h) {
        if (this.loading) {
          return h(
            'div',
            { class: { 'loading': true } },
            [
              this.renderSvg(h)
            ]
          )
        }
      },
      renderCardBody (h) {
        return h(
          'div',
          { class: { 'card-body': true } }
        )
      },
      renderMain (h) {
        return h(
          'div',
          { class: { 'table-responsive': true } },
          [
            this.renderLoader(h),
            this.renderVuetable(h),
            this.renderPagination(h)
          ]
        )
      },
      renderSvg (h) {
        return h(
          'div',
          { class: { 'loader': true } }
        )
      },
      // render related functions
      renderVuetable (h) {
        return h(
          'vuetable',
          {
            ref: 'vuetable',
            props: {
              apiUrl: this.apiUrl,
              fields: this.fields,
              paginationPath: '',
              perPage: this.perPage,
              multiSort: true,
              sortOrder: this.sortOrder,
              appendParams: this.appendParams,
              detailRowComponent: this.detailRowComponent,
              rowClass: this.rowClass,
              css: this.css.table
            },
            on: {
              'vuetable:initialized': this.onInitialized,
              'vuetable:checkbox-toggled': this.onCheckboxToggled,
              'vuetable:checkbox-toggled-all': this.onCheckboxToggledAll,
              'vuetable:cell-clicked': this.onCellClicked,
              'vuetable:pagination-data': this.onPaginationData,
              'vuetable:loading': this.onLoading,
              'vuetable:loaded': this.onLoaded
            },
            scopedSlots: this.$vnode.data.scopedSlots
          }
        )
      },
      renderPagination (h) {
        return h(
          'div',
          { class: {'datatable-footer': true} },
          [
            h('vuetable-pagination-info', { ref: 'paginationInfo', props: { css: this.css.paginationInfo } }),
            h('vuetable-pagination', {
              ref: 'pagination',
              props: { css: this.css.pagination },
              on: {
                'vuetable-pagination:change-page': this.onChangePage
              }
            })
          ]
        )
      },
      onPaginationData (paginationData) {
        this.$refs.pagination.setPaginationData(paginationData)
        this.$refs.paginationInfo.setPaginationData(paginationData)
      },
      onChangePage (page) {
        this.$refs.vuetable.changePage(page)
      },
      onCellClicked (data, field, event) {
        // this.$refs.vuetable.toggleDetailRow(data.id)
      },
      onInitialized (tableFields, description) {
      },
      onCheckboxToggled (checked, data) {
        this.$events.fire('checkbox-toggled-set', checked, data)
      },
      onCheckboxToggledAll (checked) {
        this.$events.fire('checkbox-toggled-all-set', checked)
      },
      onLoading () {
        this.$store.dispatch('block', {element: 'componentsComponent', load: true})
      },
      onLoaded () {
        this.$store.dispatch('block', {element: 'componentsComponent', load: false})
      },
      doView (action, data, index) {
        this.$refs.vuetable.toggleDetailRow(data.id)
      },
      onUninstallSuccess (response) {
        if (response.data.hasOwnProperty('success') && response.data.success === true) {
          this.$message({
            type: 'success',
            message: response.data.message
          })
          Vue.nextTick(() => this.$refs.vuetable.refresh())
        } else {
          toastr.error(response.message)
        }
      },
      onFailed (error) {
        if (error.response !== undefined && error.response.hasOwnProperty('data') && error.response.data.hasOwnProperty('errors')) {
          this.errors.record(error.response.data.errors)
          if ((error.response.data.hasOwnProperty('success') && error.response.data.success === false) || error.response.data.hasOwnProperty('message')) {
            this.$notify.error({ title: 'Error', message: error.response.data.message })
          } else {
            this.$notify.error({ title: 'Error', message: this.errors.getErrors(this.errors.errors) })
          }
        } else if (error.response !== undefined && error.response.hasOwnProperty('data') && error.response.data.hasOwnProperty('message')) {
          this.$notify.error({ title: 'Error', message: error.response.data.message })
        } else if (error.hasOwnProperty('message')) {
          this.$notify.error({ title: 'Error', message: error.message })
        } else {
          this.$notify.error({ title: 'Error', message: 'Service not answer, Please contact your Support' })
          console.log(error)
        }
      }
    }
  }
</script>
