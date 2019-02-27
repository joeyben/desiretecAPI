<template>
    <!-- Large modal -->
    <div class="card card-body bg-primary has-bg-image">
        <div class="media">
            <div class="media-body">
                <h3 class="mb-0" v-text="sellerCount"></h3>
                <span class="text-uppercase font-size-xs">{{ trans('dashboard.total_sellers') }}</span>
            </div>

            <div class="ml-3 align-self-center">
                <i class="icon-users2 icon-3x opacity-75"></i>
            </div>
        </div>
    </div>
    <!-- /large modal -->
</template>
<script>
  import Vuex from 'vuex'
  import { Errors } from '../../../../../../../../../resources/assets/js/utils/errors'
  export default {
    name: 'TileSellerComponent',
    components: { },
    data () {
      return {
        // eslint-disable-next-line
        errors: new Errors(),
        sellerCount: 0
      }
    },
    mounted () {
      this.loadSeller()
    },
    watch: {
    },
    computed: {
      ...Vuex.mapGetters({
      })
    },
    methods: {
      ...Vuex.mapActions({
      }),
      loadSeller: function () {
        this.$store.dispatch('block', {element: 'dashboardComponent', load: true})
        this.$http.get(window.laroute.route('admin.dashboard.sellers'))
          .then(this.onLoadDashboardSellerSuccess)
          .catch(this.onFailed)
          .then(() => {
            this.$store.dispatch('block', {element: 'dashboardComponent', load: false})
          })
      },
      onLoadDashboardSellerSuccess (response) {
        if (response.data.hasOwnProperty('success') && response.data.success === true) {
          this.sellerCount = response.data.sellerCount
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
