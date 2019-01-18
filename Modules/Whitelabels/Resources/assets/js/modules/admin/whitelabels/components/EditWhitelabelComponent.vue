<template>
    <!-- Large modal -->
    <div class="card">
        <div class="card-header header-elements-inline">
            <div class="card-title">
            </div>
        </div>
        <div class="card-body" v-if="start">
            <form-wizard @on-complete="onComplete"  @on-error="handleErrorMessage" :start-index="whitelabel.state" title="This is a new title" subtitle="And a new subtitle" color="#00695C">
                <tab-content title="Additional Info" :before-change="()=>validateAsync(1)">
                    <whitelabel-general-information-component ref="informationComponent"></whitelabel-general-information-component>
                </tab-content>
                <tab-content title="Additional Info" :before-change="beforeTabSwitch">
                    My second tab content
                </tab-content>
                <tab-content title="Last step">
                    Yuhuuu! This seems pretty damn simple
                </tab-content>
            </form-wizard>
        </div>
    </div>
    <!-- /large modal -->
</template>
<script>
  import Vuex from 'vuex'
  import { Errors } from '../../../../../../../../../resources/assets/js/utils/errors'
  import UploadAttachments from '../../../../../../../../../resources/assets/js/utils/UploadAttachments'
  import {FormWizard, TabContent} from 'vue-form-wizard'
  import 'vue-form-wizard/dist/vue-form-wizard.min.css'

  import WhitelabelGeneralInformationComponent from './WhitelabelGeneralInformationComponent'
  export default {
    name: 'EditWhitelabelComponent',
    components: { FormWizard, TabContent, UploadAttachments, WhitelabelGeneralInformationComponent },
    data () {
      return {
        // eslint-disable-next-line
        errors: new Errors(),
        isValid: false
      }
    },
    mounted () {
      this.loadWhitelabel(parseInt(this.$route.params.id))
    },
    watch: {
      '$route.params.id' () {
        this.loadWhitelabel(parseInt(this.$route.params.id))
      }
    },
    computed: {
      ...Vuex.mapGetters({
        user: 'currentUser',
        whitelabel: 'whitelabel'
      }),
      start () {
        return this.whitelabel.hasOwnProperty('state')
      },
      step () {
        return this.whitelabel.hasOwnProperty('state') ? this.whitelabel.state : 0
      }
    },
    methods: {
      ...Vuex.mapActions({
        addWhitelabel: 'addWhitelabel'
      }),
      handleErrorMessage: function (errorMsg) {
        this.errorMsg = errorMsg
      },
      loadWhitelabel (id) {
        this.$store.dispatch('block', {element: 'whitelabelsComponent', load: true})
        this.$http.get(window.laroute.route('admin.whitelabels.edit', {id: id}))
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
        alert('Yay. Done!')
      },
      validateAsync: function (step) {
        this.$refs.informationComponent.onSubmit()
        return new Promise((resolve, reject) => {
          setTimeout(() => {
            if (!this.isValid) {
              reject(new Error('something bad happened'))
            } else {
              this.count = 0
              resolve(true)
            }
          }, 1000)
        })
      },
      beforeTabSwitch: function (step) {
        debugger
        this.$refs.informationComponent.onSubmit()
        return this.step === step
      },
      hasPermissionTo (permission) {
        return this.user.hasOwnProperty('permissions') && this.user.permissions[permission]
      },
      hasRole (permission) {
        return this.user.hasOwnProperty('roles') && this.user.roles[permission]
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
