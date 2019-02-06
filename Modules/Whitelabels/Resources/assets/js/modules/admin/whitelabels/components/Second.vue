<template>
    <!-- Large modal -->
    <div class="card-body">
        <form action="#" @submit.prevent="onSubmit" @keydown="errors.clear($event.target.name)" id="myForm">
            <fieldset>
                <div class="collapse show" id="demo1">
                    <div class="form-group row" v-if="whitelabel.id !== 0">
                        <label class="col-lg-3 col-form-label">&nbsp;{{ trans('modals.id') }}</label>
                        <div class="col-lg-9">
                            <input type="text" class="form-control disabled" disabled readonly id='id' name='id' :placeholder="trans('modals.id')" :value="whitelabel.id"/>
                            <div class="invalid-feedback">
                                <strong v-text="errors.get('id')"></strong>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label">&nbsp;{{ trans('modals.domain') }} <span class="text-danger"> *</span></label>
                        <div class="col-lg-9">
                            <input type="text" class="form-control" :class="errors.has('domain') ? 'is-invalid': ''" id='domain' name='domain' :placeholder="trans('modals.domain')" @input="updateWhitelabel"  :value="whitelabel.domain"/>
                            <div class="invalid-feedback">
                                <strong v-text="errors.get('domain')"></strong>
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
    <!-- /large modal -->
</template>
<script>
  import Vuex from 'vuex'
  import { Errors } from '../../../../../../../../../resources/assets/js/utils/errors'
  export default {
    name: 'Second',
    components: { },
    data () {
      return {
        // eslint-disable-next-line
        errors: new Errors(),
      }
    },
    mounted () {
      this.$events.$on('on-submit-second', () => this.onSubmit())
    },
    watch: {
    },
    computed: {
      ...Vuex.mapGetters({
        user: 'currentUser',
        whitelabel: 'whitelabel'
      })
    },
    methods: {
      ...Vuex.mapActions({
        addWhitelabel: 'addWhitelabel'
      }),
      updateWhitelabel (e) {
        if (e.target.value !== null) {
          this.$store.commit('updateWhitelabel', {name: e.target.name, value: e.target.value})
        }
      },
      onSubmit () {
        this.$store.dispatch('block', {element: 'whitelabelsComponent', load: true})
        this.$http.put(window.laroute.route('admin.whitelabels.domain', {id: this.whitelabel.id}), this.whitelabel)
          .then(this.onSubmitSuccess)
          .catch(this.onFailed)
          .then(() => {
            this.$store.dispatch('block', {element: 'whitelabelsComponent', load: false})
          })
      },
      onSubmitSuccess (response) {
        if (response.data.hasOwnProperty('success') && response.data.success === true) {
          this.$parent.$parent.$data.isValidSecond = true
          this.$store.commit('updateWhitelabel', {name: 'id', value: response.data.whitelabel.id})
          this.$store.commit('updateWhitelabel', {name: 'domain', value: response.data.whitelabel.domain})
          this.$store.commit('updateWhitelabel', {name: 'state', value: response.data.whitelabel.state})
        } else {
          this.$message({
            type: 'error',
            message: response.message
          })
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
