
<script>
  import Vue from 'vue'
  import Vuex from 'vuex'
  import toastr from 'toastr'
  import accounting from 'accounting'

  import Vuetable from 'vuetable-2/src/components/Vuetable.vue'
  import VuetablePagination from 'vuetable-2/src/components/VuetablePagination'
  import VuetablePaginationInfo from 'vuetable-2/src/components/VuetablePaginationInfo'
  import config from './config'
  import FilterBar from './FilterBar'
  import CssConfig from './CssConfig.js'
  Vue.component('filter-bar', FilterBar)
  Vue.component('my-detail-row', config.detail)
  Vue.component('custom-actions', config.actions)
  toastr.options.progressBar = true
  toastr.options.preventDuplicates = true

  export default {
    name: 'VueDatatable',
    props: {
    },
    data () {
      return {
        apiUrl: window.laroute.route('admin.activities.view'),
        fields: config.fields,
        sortOrder: config.sortOrder,
        appendParams: config.moreParams,
        detailRowComponent: 'my-detail-row',
        rowClass: 'context',
        css: CssConfig,
        loading: false
      }
    },
    components: { Vuetable, VuetablePagination, VuetablePaginationInfo },
    mounted () {
      this.$events.$on('filter-set', eventData => this.onFilterSet(eventData))
      this.$events.$on('filter-reset', e => this.onFilterReset())
      this.$events.$on('view-set', (action, data, index) => this.doView(action, data, index))
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
      onFilterSet (filterText) {
        this.appendParams.filter = filterText
        Vue.nextTick(() => this.$refs.vuetable.refresh())
      },
      onFilterReset () {
        delete this.appendParams.filter
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
              perPage: 10,
              multiSort: true,
              sortOrder: this.sortOrder,
              appendParams: this.appendParams,
              detailRowComponent: this.detailRowComponent,
              rowClass: this.rowClass,
              css: this.css.table
            },
            on: {
              'vuetable:checkbox-toggled': this.onCheckboxToggled,
              'vuetable:checkbox-toggled-all': this.onCheckboxToggledAll,
              'vuetable:cell-clicked': this.onCellClicked,
              'vuetable:pagination-data': this.onPaginationData,
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
      onCheckboxToggled (checked, data) {
        this.$events.fire('checkbox-toggled-set', checked, data)
      },
      onCheckboxToggledAll (checked) {
        this.$events.fire('checkbox-toggled-all-set', checked)
      },
      onLoaded () {
        let vm = this
        $('.context').contextmenu({
          target: '.context-js-menu',
          before: function (e, element, target) {
            e.preventDefault()
            if ((e.target.children.length > 0) && e.target.children[0].classList.contains('list-icons')) {
              e.preventDefault()
              this.closemenu()
              return false
            }
            return true
          },
          onItem: function (context, e) {
            if ($(e.target).data('action') === 'edit') {
              vm.$router.push({name: 'root.edit', params: { id: parseInt(context[0].children[1].textContent) }})
            }
            if ($(e.target).data('action') === 'delete') {
              vm.doDelete(null, parseInt(context[0].children[1].textContent), null)
            }
          }
        })
      },
      urlCallback (url) {
        let urlName = url.length <= 25 ? url : url.substring(0, 25) + ' ...'
        return '<a  href="' + url + '" data-popup="tooltip" title="' + url + '" target="_blank">' + urlName + '</a>'
      },
      formatNumber (value) {
        return accounting.formatMoney(value, '€', 2, ',', '.')
      },
      doView (action, data, index) {
        this.$refs.vuetable.toggleDetailRow(data.id)
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
