<template>
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
                        <label class="col-lg-3 col-form-label">&nbsp;{{ trans('modals.name') }} <span class="text-danger"> *</span></label>
                        <div class="col-lg-9">
                            <input type="text" class="form-control" :class="errors.has('name') ? 'is-invalid': ''" :disabled="whitelabel.id > 0" :readonly="whitelabel.id > 0" id='name' name='name' :placeholder="trans('modals.name')" @input="updateWhitelabel"  :value="whitelabel.name"/>
                            <div class="invalid-feedback">
                                <strong v-text="errors.get('name')"></strong>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label">&nbsp;{{ trans('modals.display_name') }} <span class="text-danger"> *</span></label>
                        <div class="col-lg-9">
                            <input type="text" class="form-control" :class="errors.has('display_name') ? 'is-invalid': ''" id='display_name' name='display_name' :placeholder="trans('modals.display_name')" @input="updateWhitelabel"  :value="whitelabel.display_name"/>
                            <div class="invalid-feedback">
                                <strong v-text="errors.get('display_name')"></strong>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label">&nbsp;{{ trans('modals.owner') }}</label>
                        <div class="col-lg-9">
                            <input type="text" class="form-control"  id='owner' disabled readonly :placeholder="trans('modals.owner')"  :value="whitelabel.owner"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label"> &nbsp; {{ trans('validation.attributes.backend.whitelabels.associated_distribution') }}</label>
                        <div class="col-lg-9">
                            <el-select :value="whitelabel.distribution_id" :placeholder="trans('labels.group')" size="small" style="width: 100%;" @input="inputDistribution">
                                <el-option
                                        v-for="item in whitelabel.distributions"
                                        :key="item.id"
                                        :label="item.name"
                                        :value="item.id">
                                    <span style="float: left"><i :class="item.name"></i> {{ item.name }}</span>
                                </el-option>
                            </el-select>
                            <div class="invalid-feedback">
                                <strong v-text="errors.get('distribution_id')"></strong>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label">&nbsp; {{ trans('modals.status') }} </label>
                        <div class="col-lg-9">
                            <el-switch
                                    @input="updateStatus"
                                    :value="whitelabel.status"
                                    active-color="#13ce66"
                                    inactive-color="#ff4949">
                            </el-switch>
                        </div>
                    </div>

                    <legend class="font-weight-semibold"><i class="icon-upload mr-2"></i> {{ trans('validation.attributes.backend.whitelabels.image') }}</legend>
                    <div class="form-group row">
                        <upload-attachments :data="{name: 'background'}" :fileList="whitelabel.background" :limit="1" listType="picture-card"></upload-attachments>
                        <div class="help-block text-danger" v-if="errors.has('background')">
                            <strong v-text="errors.get('background')"></strong>
                        </div>
                    </div>

                    <legend class="font-weight-semibold"><i class="icon-upload mr-2"></i> Logo </legend>
                    <div class="form-group row">
                        <upload-attachments :data="{name: 'logo'}" :fileList="whitelabel.logo" :limit="1" listType="picture-card"></upload-attachments>
                        <div class="help-block text-danger" v-if="errors.has('logo')">
                            <strong v-text="errors.get('logo')"></strong>
                        </div>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
</template>
<script>
  import Vuex from 'vuex'
  import { Errors } from '../../../../../../../../../resources/assets/js/utils/errors'
  import UploadAttachments from '../../../../../../../../../resources/assets/js/utils/UploadAttachments'
  export default {
    name: 'First',
    components: { UploadAttachments },
    data () {
      return {
        // eslint-disable-next-line
        errors: new Errors(),
      }
    },
    mounted () {
      this.$events.$on('on-submit-first', () => this.onSubmit())
      this.$events.$on('handle-success-file', response => this.handleSuccessFile(response))
      this.$events.$on('handle-remove-file', response => this.handleRemoveFile(response))
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
      onSubmit () {
        if (this.whitelabel.id > 0) {
          this.$store.dispatch('block', {element: 'whitelabelsComponent', load: true})
          this.$http.put(window.laroute.route('admin.whitelabels.update', {id: this.whitelabel.id}), this.whitelabel)
            .then(this.onSubmitSuccess)
            .catch(this.onFailed)
            .then(() => {
              this.$store.dispatch('block', {element: 'whitelabelsComponent', load: false})
            })
        } else {
          this.$store.dispatch('block', {element: 'whitelabelsComponent', load: true})
          this.$http.put(window.laroute.route('admin.whitelabels.store'), this.whitelabel)
            .then(this.onSubmitSuccess)
            .catch(this.onFailed)
            .then(() => {
              this.$store.dispatch('block', {element: 'whitelabelsComponent', load: false})
            })
        }
      },
      onSubmitSuccess (response) {
        if (response.data.hasOwnProperty('success') && response.data.success === true) {
          this.$parent.$parent.$data.isValid = true
          this.$store.commit('updateWhitelabel', {name: 'id', value: response.data.whitelabel.id})
          this.$store.commit('updateWhitelabel', {name: 'name', value: response.data.whitelabel.name})
          this.$store.commit('updateWhitelabel', {name: 'state', value: response.data.whitelabel.state})
        } else {
          this.$message({
            type: 'error',
            message: response.message
          })
        }
      },
      handleSuccessFile (response) {
        if (response !== undefined) {
          this.$store.commit('addWhitelabelFile', response)
          this.errors.clear(response.name)
        }
      },
      handleRemoveFile (response) {
        if (response !== undefined) {
          this.$store.commit('removeWhitelabelFile', response.data)
        }
      },
      handleFileUploadBg () {
        this.$store.commit('updateWhitelabel', {name: 'bg_image', value: this.$refs.bg_image.files[0]})
      },
      updateStatus (value) {
        this.$store.commit('updateWhitelabel', {name: 'status', value: value})
      },
      inputDistribution (value) {
        this.$store.commit('updateWhitelabel', {name: 'distribution_id', value: value})
      },
      updateWhitelabel (e) {
        if (e.target.value !== null) {
          this.$store.commit('updateWhitelabel', {name: e.target.name, value: e.target.value})
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
