
<script>
  import Vue from 'vue'
  import Vuex from 'vuex'
  import toastr from 'toastr'

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
  Vue.component('custom-link-by-name', config.customLinkByName)
  Vue.component('custom-user', config.customUser)
  toastr.options.progressBar = true
  toastr.options.preventDuplicates = true

  export default {
    name: 'VueDatatable',
    props: {
    },
    data () {
      return {
        apiUrl: window.laroute.route('admin.backups.view'),
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
      this.$events.$on('show-set', fields => this.onShowSet(fields))
      this.$events.$on('page-set', perPage => this.onPageSet(perPage))
      this.$events.$on('delete-set', (action, data, index) => this.doDelete(action, data, index))
      this.$events.$on('create-backup', e => this.doCreate())
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
      onShowSet (fields) {
        this.fields = fields
        Vue.nextTick(() => this.$refs.vuetable.normalizeFields(this.fields))
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
        this.$store.dispatch('block', {element: 'backupsComponent', load: true})
      },
      onLoaded () {
        this.$store.dispatch('block', {element: 'backupsComponent', load: false})
      },
      categoriesCallBack (categories) {
        let data = []
        categories.forEach((category) => {
          data.push('<span class="text-teal-300">' + category.name + '</span>')
        })
        return data.join(', ')
      },
      doCreate () {
        this.$http.get(window.laroute.route('admin.backups.create'))
          .then(this.onCreateSuccess)
          .catch(this.onFailed)
          .then(function () {
          })
      },
      doDelete (action, id, index) {
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
      onCreateSuccess (response) {
        if (response.data.hasOwnProperty('success') && response.data.success === true) {
          this.$notify.success({ title: 'success', message: response.data.message })
          Vue.nextTick(() => this.$refs.vuetable.refresh())
        } else {
          this.$notify.error({ title: 'Error', message: response.message })
        }
      },
      onDelete (id) {
        this.$store.dispatch('block', {element: 'backupsComponent', load: true})
        // eslint-disable-next-line
        this.$http.delete(laroute.route('admin.backups.destroy', {file: id}))
          .then(this.onDeleteSuccess)
          .catch(this.onFailed)
          .then(() => {
            this.$store.dispatch('block', {element: 'backupsComponent', load: false})
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
