<script>
  import Vue from 'vue'
  import Vuex from 'vuex'
  import toastr from 'toastr'
  import moment from 'moment'

  import Vuetable from 'vuetable-2/src/components/Vuetable.vue'
  import config from './config'
  import FilterBar from './FilterBar'
  import CssConfig from './CssConfig.js'

  Vue.component('filter-bar', FilterBar)
  toastr.options.progressBar = true
  toastr.options.preventDuplicates = true
  moment.locale(window.i18.lang)

  export default {
    name: 'GaDatatableComponent',
    props: {},
    data () {
      return {
        apiUrl: window.laroute.route('provider.dashboard.ga'),
        fields: config.fields,
        appendParams: config.moreParams,
        rowClass: 'context',
        css: CssConfig,
        loading: false
      }
    },
    components: {Vuetable},
    mounted () {
      this.$events.$on('whitelabel-set', (id) => this.doWhitelabel(id))
    },
    render (h) {
      return h(
        'div',
        {
          class: {'card': true}
        },
        [
          h('filter-bar'),
          this.renderCardBody(h),
          this.renderMain(h)
        ]
      )
    },
    methods: {
      ...Vuex.mapActions({}),
      refresh () {
        Vue.nextTick(() => this.$refs.vuetable.refresh())
      },
      renderLoader (h) {
        if (this.loading) {
          return h(
            'div',
            {class: {'loading': true}},
            [
              this.renderSvg(h)
            ]
          )
        }
      },
      renderCardBody (h) {
        return h(
          'div',
          {class: {'card-body': true}}
        )
      },
      renderMain (h) {
        return h(
          'div',
          {class: {'table-responsive': true}},
          [
            this.renderLoader(h),
            this.renderVuetable(h)
          ]
        )
      },
      renderSvg (h) {
        return h(
          'div',
          {class: {'loader': true}}
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
              appendParams: this.appendParams,
              css: this.css.table
            },
            on: {
              'vuetable:initialized': this.onInitialized,
              'vuetable:loading': this.onLoading,
              'vuetable:loaded': this.onLoaded
            },
            scopedSlots: this.$vnode.data.scopedSlots
          }
        )
      },
      onInitialized (tableFields, description) {
      },
      onLoading () {
        this.$store.dispatch('block', {element: 'dashboardComponent', load: true})
      },
      onLoaded () {
        this.$store.dispatch('block', {element: 'dashboardComponent', load: false})
      },
      doWhitelabel (id) {
        this.appendParams.whitelabel = id
        Vue.nextTick(() => this.$refs.vuetable.refresh())
      },
      onFailed (error) {
        if (error.response !== undefined && error.response.hasOwnProperty('data') && error.response.data.hasOwnProperty('errors')) {
          this.errors.record(error.response.data.errors)
          if ((error.response.data.hasOwnProperty('success') && error.response.data.success === false) || error.response.data.hasOwnProperty('message')) {
            this.$notify.error({title: 'Error', message: error.response.data.message})
          } else {
            this.$notify.error({title: 'Error', message: this.errors.getErrors(this.errors.errors)})
          }
        } else if (error.response !== undefined && error.response.hasOwnProperty('data') && error.response.data.hasOwnProperty('message')) {
          this.$notify.error({title: 'Error', message: error.response.data.message})
        } else if (error.hasOwnProperty('message')) {
          this.$notify.error({title: 'Error', message: error.message})
        } else {
          this.$notify.error({title: 'Error', message: 'Service not answer, Please contact your Support'})
          console.log(error)
        }
      }
    }
  }
</script>
