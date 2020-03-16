<template>
    <!-- Large modal -->
    <div id="modal_large_whitelabel" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-steel">
                    <h5 class="modal-title"><i class="icon-menu7 mr-2"></i></h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <ul class="nav nav-tabs nav-tabs-bottom border-bottom-0 nav-justified">
                    <li class="nav-item" v-if="true"><a href="#highlighted-justified-tab1" class="nav-link active" data-toggle="tab"><i class="icon-pencil6 mr-2"></i></a></li>
                    <li class="nav-item" v-if="true"><a href="#highlighted-justified-tab2" class="nav-link" data-toggle="tab"><i class="icon-file-text mr-2"></i></a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="highlighted-justified-tab1">
                        <div class="card-body">
                            <form action="#" @submit.prevent="onSubmit" @keydown="errors.clear($event.target.name)">
                                <div class="modal-body">
                                    <fieldset>
                                        <legend class="font-weight-semibold text-uppercase font-size-sm">
                                            <i class="icon-check mr-2"></i>
                                            {{ trans('modals.whitelabel') }}
                                            <a class="float-right text-default" data-toggle="collapse" data-target="#demo1">
                                                <i class="icon-circle-down2"></i>
                                            </a>
                                        </legend>
                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label">&nbsp;{{ trans('modals.id') }} <span class="text-danger"> *</span></label>
                                            <div class="col-lg-9">
                                                <input type="text" class="form-control" :class="errors.has('id') ? 'is-invalid': ''" id='id' name='id' :placeholder="trans('modals.id')" disabled readonly :value="whitelabel.id"/>
                                                <div class="invalid-feedback">
                                                    <strong v-text="errors.get('id')"></strong>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label">&nbsp;{{ trans('modals.name') }} <span class="text-danger"> *</span></label>
                                            <div class="col-lg-9">
                                                <input type="text" class="form-control" :class="errors.has('name') ? 'is-invalid': ''" id='name' name='name' :placeholder="trans('modals.name')"  :value="whitelabel.name" @input="updateWhitelabel"/>
                                                <div class="invalid-feedback">
                                                    <strong v-text="errors.get('name')"></strong>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label">&nbsp;{{ trans('modals.email') }} <span class="text-danger"> *</span></label>
                                            <div class="col-lg-9">
                                                <input type="email" class="form-control" :class="errors.has('email') ? 'is-invalid': ''" id='email' name='email' :placeholder="trans('modals.email')" @input="updateWhitelabel"  :value="whitelabel.email"/>
                                                <div class="invalid-feedback">
                                                    <strong v-text="errors.get('email')"></strong>
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
                                            <label class="col-lg-3 col-form-label">&nbsp; {{ trans('modals.licence') }} </label>
                                            <div class="col-lg-9">
                                                <el-radio-group :value="whitelabel.licence" @input="updateLicence">
                                                    <el-radio-button label="0">Light</el-radio-button>
                                                    <el-radio-button label="1">Basic</el-radio-button>
                                                    <el-radio-button label="2">Premium</el-radio-button>
                                                </el-radio-group>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-outline bg-teal-600 text-teal-600 border-teal-600 btn-sm" v-on:click="close = false"><i class="icon-checkmark-circle mr-1"></i>{{ trans('button.save') }}</button>
                                    <button type="submit" class="btn btn-outline bg-teal-400 text-teal-400 border-teal-400 btn-sm" v-on:click="close = true"><i class="icon-checkmark-circle mr-1"></i>{{ trans('button.save_and_close') }}</button>
                                    <button type="button" class="btn btn-outline-danger btn-sm" data-dismiss="modal"><i class="icon-cancel-circle2 mr-1"></i> {{ trans('button.close') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="highlighted-justified-tab2" v-if="true">
                        <div class="modal-body">
                            <vue-table :options="whitelabel.logs"></vue-table>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-danger btn-sm" data-dismiss="modal"><i class="icon-cancel-circle2 mr-1"></i> {{ trans('button.close') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /large modal -->
</template>
<script>
  import Vuex from 'vuex'
  import { Errors } from '../../../../../../../../../resources/assets/js/utils/errors'
  import VueTable from '../../../../../../../../../resources/assets/js/utils/Table.vue'
  import UploadAttachments from '../../../../../../../../../resources/assets/js/utils/UploadAttachments'
  import TagComponent from './TagComponent'

  export default {
    name: 'ApiWhitelabelComponent',
    components: { VueTable, UploadAttachments, TagComponent },
    data () {
      return {
        // eslint-disable-next-line
        errors: new Errors(),
        close: false
      }
    },
    mounted () {
      this.loadModal()
    },
    watch: {
      '$route.params.id' () {
        this.EditWhitelabel(parseInt(this.$route.params.id))
      }
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
      updateLicence (value) {
        this.$store.commit('updateWhitelabel', {name: 'licence', value: value})
      },
      handleSuccessFile (response) {
        if (response !== undefined) {
          this.$store.commit('addWhitelabelFile', response.attachment)
          this.errors.clear(response.attachment.type.replace('whitelabels/', ''))
        }
      },
      handleRemoveFile (response) {
        if (response !== undefined) {
          this.$store.commit('removeWhitelabelFile', response.data.attachment)
        }
      },
      updateWhitelabel (e) {
        if (e.target.value !== null) {
          this.$store.commit('updateWhitelabel', {name: e.target.name, value: e.target.value})
        }
      },
      updateStatus (value) {
        this.$store.commit('updateWhitelabel', {name: 'status', value: value})
      },
      inputDistribution (value) {
        this.$store.commit('updateWhitelabel', {name: 'distribution_id', value: value})
      },
      loadModal () {
        $('#modal_large_whitelabel').on('hidden.bs.modal', () => {
          this.$router.push({name: 'root'})
        })

        this.createWhitelabel()
      },
      handleErrorMessage: function (errorMsg) {
        this.errorMsg = errorMsg
      },
      createWhitelabel () {
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
          if (!($('#modal_large_whitelabel').data('bs.modal') || {}).isShown) {
            $('#modal_large_whitelabel').modal('show')
          }
        } else {
          this.$message({
            type: 'error',
            message: response.message
          })
        }
      },
      onSubmit () {
        this.$store.dispatch('block', {element: 'whitelabelsComponent', load: true})
        this.$http.post(window.laroute.route('admin.whitelabels.api.store'), this.whitelabel)
          .then(this.onSubmitSuccess)
          .catch(this.onFailed)
          .then(() => {
            this.$store.dispatch('block', {element: 'whitelabelsComponent', load: false})
          })
      },
      onSubmitSuccess (response) {
        if (response.data.hasOwnProperty('success') && response.data.success === true) {
          if (this.close) {
            $('#modal_large_whitelabel').modal('hide')
            this.$router.push({name: 'root'})
          } else {
            $('#modal_large_whitelabel').modal('hide')
            this.$router.push({name: 'root.edit', params: {id: response.data.whitelabel.id}})
          }
          this.$message({
            message: response.data.message,
            showClose: true,
            type: 'success'
          })
          this.$parent.$children[0].refresh()
        } else {
          this.$notify.error({ title: 'Failed', message: response.data.message })
        }
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
