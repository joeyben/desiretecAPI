
<script>
  import Vue from 'vue'
import Vuex from 'vuex'
import toastr from 'toastr'
import accounting from 'accounting'
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
  Vue.component('custom-link-by-name', config.CustomLinkByName)
  Vue.component('custom-status', config.CustomStatus)
  Vue.component('custom-users', config.customUsers)
  toastr.options.progressBar = true
  toastr.options.preventDuplicates = true
  moment.locale(window.i18.lang)

  export default {
    name: 'VueDatatable',
    props: {
    },
    data () {
      return {
        apiUrl: window.laroute.route('provider.languages.view'),
        fields: config.fields,
        sortOrder: config.sortOrder,
        appendParams: config.moreParams,
        perPage: config.perPage,
        detailRowComponent: 'my-detail-row',
        rowClass: 'context',
        css: CssConfig,
        loading: false,
        checked: []
      }
    },
    components: { Vuetable, VuetablePagination, VuetablePaginationInfo },
    mounted () {
      this.$events.$on('filter-set', eventData => this.onFilterSet(eventData))
      this.$events.$on('show-set', fields => this.onShowSet(fields))
      this.$events.$on('page-set', perPage => this.onPageSet(perPage))
      this.$events.$on('filter-reset', e => this.onFilterReset())
      this.$events.$on('view-set', (action, data, index) => this.doView(action, data, index))
      this.$events.$on('delete-set', (id) => this.doDelete(id))
      this.$events.$on('destroy-set', (id) => this.doDestroy(id))
      this.$events.$on('restore-set', (id) => this.doRestore(id))
      this.$events.$on('range-date-set', (start, end) => this.doRangeDate(start, end))
      this.$events.$on('whitelabel-set', (id) => this.doWhitelabel(id))
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
        addChecked: 'addChecked',
        addCheckedId: 'addCheckedId',
        removeCheckedId: 'removeCheckedId'
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
      doRangeDate (start, end) {
        this.appendParams.start = start
        this.appendParams.end = end
        Vue.nextTick(() => this.$refs.vuetable.refresh())
      },
      doWhitelabel (id) {
        this.appendParams.whitelabel = id
        Vue.nextTick(() => this.$refs.vuetable.refresh())
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
        if (checked) {
          this.addCheckedId(data.id)
        } else {
          this.removeCheckedId(data.id)
        }
      },
      onCheckboxToggledAll (checked) {
        let data = []
        if (checked) {
          this.$refs.vuetable.tableData.forEach((row, index) => {
            data.push(row.id)
          })
        }

        this.addChecked(data)
      },
      onLoading () {
        this.$store.dispatch('block', {element: 'groupsComponent', load: true})
      },
      onLoaded () {
        this.$store.dispatch('block', {element: 'groupsComponent', load: false})
      },
      boardsCallBack (boards) {
        let data = []
        boards.forEach((board) => {
          data.push('<span class="text-teal-300">' + board.name + '</span>')
        })
        return data.join(', ')
      },
      formatNumber (value) {
        return accounting.formatMoney(value, '€ ', 0, '.', '.')
      },
      formatDate (value, fmt = 'D MMM YYYY') {
        return (value == null)
          ? ''
          : moment(value, 'YYYY-MM-DD HH:mm:ss').format(fmt)
      },
      doView (action, data, index) {
        this.$refs.vuetable.toggleDetailRow(data.id)
      },
      doDelete (id) {
        this.$confirm(this.trans('messages.delete'), 'Warning', {
          confirmButtonText: this.trans('labels.ok'),
          cancelButtonText: this.trans('labels.cancel'),
          type: 'warning'
        }).then(() => {
          this.onDelete(id)
        }).catch(() => {
          this.$message({
            type: 'info',
            message: this.trans('messages.delete_canceled')
          })
        })
      },
      doDestroy (id) {
        this.$confirm(this.trans('messages.destroy'), 'Warning', {
          confirmButtonText: this.trans('labels.ok'),
          cancelButtonText: this.trans('labels.cancel'),
          type: 'warning'
        }).then(() => {
          this.onForceDelete(id)
        }).catch(() => {
          this.$message({
            type: 'info',
            message: this.trans('messages.delete_canceled')
          })
        })
      },
      doRestore (id) {
        this.$confirm(this.trans('messages.restore'), 'Warning', {
          confirmButtonText: this.trans('labels.ok'),
          cancelButtonText: this.trans('labels.cancel'),
          type: 'warning'
        }).then(() => {
          this.onRestore(id)
        }).catch(() => {
          this.$message({
            type: 'info',
            message: this.trans('messages.restore_canceled')
          })
        })
      },
      onDelete (id) {
        this.$store.dispatch('block', {element: 'groupsComponent', load: true})
        this.$http.delete(window.laroute.route('provider.groups.destroy', {id: id}))
          .then(this.onDeleteSuccess)
          .catch(this.onFailed)
          .then(() => {
            this.$store.dispatch('block', {element: 'groupsComponent', load: false})
          })
      },
      onForceDelete (id) {
        this.$store.dispatch('block', {element: 'groupsComponent', load: true})
        // eslint-disable-next-line
        this.$http.delete(laroute.route('provider.groups.forceDelete', {id: id}))
          .then(this.onDeleteSuccess)
          .catch(this.onFailed)
          .then(() => {
            this.$store.dispatch('block', {element: 'groupsComponent', load: false})
          })
      },
      onRestore (id) {
        this.$store.dispatch('block', {element: 'groupsComponent', load: true})
        // eslint-disable-next-line
        this.$http.put(window.laroute.route('provider.groups.restore', {id: id}))
          .then(this.onDeleteSuccess)
          .catch(this.onFailed)
          .then(() => {
            this.$store.dispatch('block', {element: 'groupsComponent', load: false})
          })
      },
      onDeleteSuccess (response) {
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
