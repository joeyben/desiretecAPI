<template>
    <!-- Large modal -->
    <div class="card">
        <div class="card-header header-elements-inline">
            <div class="card-title">
            </div>
        </div>
        <div class="card-body">
            <form-wizard @on-complete="onComplete"
                         :title="trans('labels.whitelabel_title')"
                         :subtitle="trans('labels.whitelabel_subtitle')"
                         :back-button-text="trans('labels.go_back')"
                         :next-button-text="trans('labels.go_next')"
                         :finish-button-text="trans('labels.finish')"
                         shape="circle"
                         color="rgb(19, 206, 102)">
                <tab-content :title="trans('labels.whitelabel_information')"
                             route="/first"
                             ref="first"
                             :before-change="validateAsyncFirst">
                </tab-content>
                <tab-content :title="trans('labels.domain')"
                             route="/second"
                             :before-change="validateAsyncLSecond">
                </tab-content>
                <tab-content :title="trans('labels.whitelabel_executive')"
                             route="/third">
                </tab-content>
                <transition name="fade" mode="out-in">
                    <router-view></router-view>
                </transition>
            </form-wizard>
        </div>
    </div>
    <!-- /large modal -->
</template>
<script>
  import Vuex from 'vuex'
import { Errors } from '../../../../../../../../../resources/assets/js/utils/errors'
import {FormWizard, TabContent} from 'vue-form-wizard'
import 'vue-form-wizard/dist/vue-form-wizard.min.css'

  export default {
    name: 'CreateWhitelabelComponent',
    components: { FormWizard, TabContent },
    data () {
      return {
        // eslint-disable-next-line
        errors: new Errors(),
        isValidSecond: false,
        isValid: false
      }
    },
    mounted () {
      this.loadWhitelabel()
    },
    watch: {
    },
    computed: {
      ...Vuex.mapGetters({
        whitelabel: 'whitelabel'
      })
    },
    methods: {
      ...Vuex.mapActions({
        addWhitelabel: 'addWhitelabel'
      }),
      loadWhitelabel () {
        this.$store.dispatch('block', {element: 'whitelabelsComponent', load: true})
        this.$http.get(window.laroute.route('admin.whitelabels.create'))
          .then(this.onLoadWhitelabelSuccess)
          .catch(this.onFailed)
          .then(() => {
            this.$store.dispatch('block', {element: 'whitelabelsComponent', load: false})
          })
      },
      onLoadWhitelabelSuccess (response) {
        if (response.data.hasOwnProperty('success') && response.data.success === true) {
          this.addWhitelabel(response.data.whitelabel)
        } else {
          this.$message({
            type: 'error',
            message: response.message
          })
        }
      },
      onComplete: function () {
        this.$confirm(this.trans('messages.whitelabel_user') + ' ?', 'Warning', {
          confirmButtonText: this.trans('labels.ok'),
          cancelButtonText: this.trans('labels.cancel'),
          type: 'warning'
        }).then(() => {
          window.location.href = window.laroute.route('admin.access.user.create')
        }).catch(() => {
          window.location.href = window.laroute.route('admin.whitelabels')
        })
      },
      validateAsyncFirst: function () {
        this.$events.fire('on-submit-first')
        return new Promise((resolve, reject) => {
          setTimeout(() => {
            if (!this.isValid) {
              reject(new Error('something bad happened'))
            } else {
              this.isValid = false
              resolve(true)
            }
          }, 1000)
        })
      },
      validateAsyncLSecond: function () {
        this.$events.fire('on-submit-second')
        return new Promise((resolve, reject) => {
          setTimeout(() => {
            if (!this.isValidSecond) {
              reject(new Error('something bad happened'))
            } else {
              this.isValidSecond = false
              resolve(true)
            }
          }, 1000)
        })
      },
      beforeTabSwitch: function () {
        return true
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
