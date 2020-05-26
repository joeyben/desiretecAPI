<template>
    <!-- Large modal -->
    <div id="modal_large_group" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-steel">
                    <h5 class="modal-title"><i class="icon-menu7 mr-2"></i></h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <ul class="nav nav-tabs nav-tabs-bottom border-bottom-0 nav-justified">
                    <li class="nav-item" v-if="can_logs"><a href="#highlighted-justified-tab1" class="nav-link active" data-toggle="tab"><i class="icon-pencil6 mr-2"></i></a></li>
                    <li class="nav-item" v-if="can_logs"><a href="#highlighted-justified-tab2" class="nav-link" data-toggle="tab"><i class="icon-file-text mr-2"></i></a></li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane fade show active" id="highlighted-justified-tab1">
                        <div class="card-body">
                            <form action="#" @submit.prevent="onSubmit" @keydown="errors.clear($event.target.name)">
                                <div class="modal-body">
                                    <fieldset>
                                        <legend class="font-weight-semibold text-uppercase font-size-sm">
                                            <i class="icon-collaboration mr-2"></i>
                                            Variant details
                                            <a class="float-right text-default" data-toggle="collapse" data-target="#demo1">
                                                <i class="icon-circle-down2"></i>
                                            </a>
                                        </legend>
                                        <div class="collapse show" id="demo1">
                                            <div class="form-group row" v-if="variant.id !== 0">
                                                <label class="col-lg-3 col-form-label">&nbsp;{{ trans('modals.id') }}</label>
                                                <div class="col-lg-9">
                                                    <input type="text" class="form-control disabled" disabled readonly id='id' name='id' :placeholder="trans('modals.id')" :value="variant.id"/>
                                                    <div class="invalid-feedback">
                                                        <strong v-text="errors.get('id')"></strong>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">&nbsp; {{ trans('modals.users') }} <span class="text-danger"> *</span></label>
                                                <div class="col-lg-9">
                                                    <el-select
                                                            style="width: 100%;"
                                                            :value="variant.layer_whitelabel_id"
                                                            clearable
                                                            placeholder="Select"
                                                            @input="inputLayerWhitelabel">
                                                        <el-option
                                                                v-for="item in variant.layerWhitelabelsList"
                                                                :key="item.id"
                                                                :label="item.whitelabel + ' - ' + item.layer"
                                                                :value="item.id"                                                                >
                                                        </el-option>
                                                    </el-select>
                                                    <div class="help-block text-danger" v-if="errors.has('users')">
                                                        <strong v-text="errors.get('users')"></strong>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">&nbsp;{{ trans('modals.headline') }} <span class="text-danger"> *</span></label>
                                                <div class="col-lg-9">
                                                    <input type="text" class="form-control" :class="errors.has('headline') ? 'is-invalid': ''" id='headline' name='headline' :placeholder="trans('modals.headline')" @input="updateVariant"  :value="variant.headline"/>
                                                    <div class="invalid-feedback">
                                                        <strong v-text="errors.get('headline')"></strong>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">&nbsp; {{ trans('modals.headline_success') }}<span class="text-danger"> *</span></label>
                                                <div class="col-lg-9">
                                                    <textarea class="form-control" :class="errors.has('headline_success') ? 'is-invalid': ''" rows="5" id='headline_success' name='headline_success' :placeholder="trans('modals.headline_success')" @input="updateVariant"  :value="variant.headline_success"></textarea>
                                                    <div class="invalid-feedback">
                                                        <strong v-text="errors.get('headline_success')"></strong>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">&nbsp;{{ trans('modals.subheadline') }} <span class="text-danger"> *</span></label>
                                                <div class="col-lg-9">
                                                    <input type="text" class="form-control" :class="errors.has('subheadline') ? 'is-invalid': ''" id='subheadline' name='subheadline' :placeholder="trans('modals.subheadline')" @input="updateVariant"  :value="variant.subheadline"/>
                                                    <div class="invalid-feedback">
                                                        <strong v-text="errors.get('subheadline')"></strong>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">&nbsp; {{ trans('modals.subheadline_success') }}<span class="text-danger"> *</span></label>
                                                <div class="col-lg-9">
                                                    <textarea class="form-control" :class="errors.has('subheadline_success') ? 'is-invalid': ''" rows="5" id='subheadline_success' name='subheadline_success' :placeholder="trans('modals.subheadline_success')" @input="updateVariant"  :value="variant.subheadline_success"></textarea>
                                                    <div class="invalid-feedback">
                                                        <strong v-text="errors.get('subheadline_success')"></strong>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">&nbsp;{{ trans('modals.layer_url') }} <span class="text-danger"> *</span></label>
                                                <div class="col-lg-9">
                                                    <input type="url" class="form-control" :class="errors.has('layer_url') ? 'is-invalid': ''" id='layer_url' name='layer_url' :placeholder="trans('modals.layer_url')" @input="updateVariant"  :value="variant.layer_url"/>
                                                    <div class="invalid-feedback">
                                                        <strong v-text="errors.get('layer_url')"></strong>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">&nbsp;{{ trans('modals.privacy') }} <span class="text-danger"> *</span></label>
                                                <div class="col-lg-9">
                                                    <input type="text" class="form-control" :class="errors.has('privacy') ? 'is-invalid': ''" id='privacy' name='privacy' :placeholder="trans('modals.privacy')" @input="updateVariant"  :value="variant.privacy"/>
                                                    <div class="invalid-feedback">
                                                        <strong v-text="errors.get('privacy')"></strong>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">&nbsp; {{ trans('modals.status') }} </label>
                                                <div class="col-lg-9">
                                                    <el-switch
                                                            @input="updateStatus"
                                                            :value="variant.active"
                                                            active-color="#13ce66"
                                                            inactive-color="#ff4949">
                                                    </el-switch>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">&nbsp;{{ trans('modals.primary_color') }} <span class="text-danger"> *</span></label>
                                                <div class="col-lg-9">
                                                    <el-color-picker :value="variant.color" @input="updateWhitelabelColor"></el-color-picker>
                                                    <div class="help-block text-danger">
                                                        <strong v-text="errors.get('color')"></strong>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">&nbsp;{{ trans('modals.owner') }}</label>
                                                <div class="col-lg-9">
                                                    <input type="text" class="form-control"  id='user' disabled readonly :placeholder="trans('modals.user')"  :value="variant.user"/>
                                                </div>
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

                    <div class="tab-pane fade" id="highlighted-justified-tab2" v-if="can_logs">
                        <div class="modal-body">
                            <vue-table :options="variant.logs"></vue-table>
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
  import moment from 'moment'
  import { Errors } from '../../../../../../../../../resources/assets/js/utils/errors'
  import VueTable from '../../../../../../../../../resources/assets/js/utils/Table.vue'
  import DateComponent from './DateComponent'
  import toastr from 'toastr'
  moment.locale(window.i18.lang)
  export default {
    name: 'EditGroupComponent',
    components: { VueTable, DateComponent },
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
        this.EditVariant(parseInt(this.$route.params.id))
      }
    },
    computed: {
      ...Vuex.mapGetters({
        variant: 'variant',
        user: 'currentUser'
      }),
      can_logs () {
        return !this.deleted && this.hasPermissionTo('logs-group')
      },
      deactivate_until () {
        return moment(this.variant.deactivate_until, moment.ISO_8601).format('DD.MM.YYYY')
      }
    },
    methods: {
      ...Vuex.mapActions({
        addVariant: 'addVariant'
      }),
      hasPermissionTo (permission) {
        return this.user.hasOwnProperty('permissions') && this.user.permissions[permission]
      },
      hasRole (permission) {
        return this.user.hasOwnProperty('roles') && this.user.roles[permission]
      },
      layerWhitelabelsList () {
        let data = []
        if (this.variant.hasOwnProperty('layerWhitelabelsList')) {
          this.variant['layerWhitelabelsList'].forEach((layerWhitelabel, index) => {
            data.push({
              label: layerWhitelabel['whitelabel'] + ' - ' + layerWhitelabel['layer'],
              key: layerWhitelabel['id']
            })
          })
        }

        return data
      },
      inputLayerWhitelabel (value) {
        this.$store.commit('updateVariant', {name: 'layer_whitelabel_id', value: value})
      },
      getVariant (key, value) {
        return (this.variant.hasOwnProperty(key)) ? this.variant[key][value] : ''
      },
      updateVariant (e) {
        if (e.target.value !== null) {
          this.$store.commit('updateVariant', {name: e.target.name, value: e.target.value})
        }
      },
      updateStatus (value) {
        this.$store.commit('updateVariant', {name: 'active', value: value})
      },
      updateWhitelabelColor (value) {
        this.$store.commit('updateVariant', {name: 'color', value: value})
      },
      updateCurrent (value) {
        this.$store.commit('updateVariant', {name: 'current', value: value})
      },
      loadModal () {
        let id = parseInt(this.$route.params.id)
        $('#modal_large_group').on('hidden.bs.modal', () => {
          this.$router.push({name: 'root'})
        })

        if (id === 0) {
          this.CreateVariant(parseInt(this.$route.params.whitelabel_id))
        } else {
          this.EditVariant(id)
        }
      },
      CreateVariant (whitelabelId) {
        this.$store.dispatch('block', {element: 'variantsComponent', load: true})
        this.$http.get(window.laroute.route('admin.variants.create', {whitelabelId: whitelabelId}))
          .then(this.onLoadVariantSuccess)
          .catch(this.onFailed)
          .then(() => {
            this.$store.dispatch('block', {element: 'variantsComponent', load: false})
          })
      },
      EditVariant (id) {
        this.$store.dispatch('block', {element: 'variantsComponent', load: true})
        this.$http.get(window.laroute.route('admin.variants.edit', {id: id}))
          .then(this.onLoadVariantSuccess)
          .catch(this.onFailed)
          .then(() => {
            this.$store.dispatch('block', {element: 'variantsComponent', load: false})
          })
      },
      onLoadVariantSuccess (response) {
        if (response.data.hasOwnProperty('success') && response.data.success === true) {
          this.addVariant(response.data.variant)
          if (!($('#modal_large_group').data('bs.modal') || {}).isShown) {
            $('#modal_large_group').modal('show')
          }
        } else {
          toastr.error(response.data.message)
        }
      },
      onSubmit (e) {
        let id = parseInt(this.$route.params.id)
        if (id === 0) {
          this.onSubmitStore()
        } else {
          this.onSubmitUpdate(id)
        }
      },
      onSubmitStore () {
        this.$store.dispatch('block', {element: 'variantsComponent', load: true})
        this.$http.put(window.laroute.route('admin.variants.store'), this.variant)
          .then(this.onSubmitSuccess)
          .catch(this.onFailed)
          .then(() => {
            this.$store.dispatch('block', {element: 'variantsComponent', load: false})
          })
      },
      onSubmitUpdate (id) {
        this.$store.dispatch('block', {element: 'variantsComponent', load: true})
        this.$http.put(window.laroute.route('admin.variants.update', {id: id}), this.variant)
          .then(this.onSubmitSuccess)
          .catch(this.onFailed)
          .then(() => {
            this.$store.dispatch('block', {element: 'variantsComponent', load: false})
          })
      },
      onSubmitSuccess (response) {
        if (response.data.hasOwnProperty('success') && response.data.success === true) {
          if (this.close) {
            $('#modal_large_group').modal('hide')
            this.$router.push({name: 'root'})
          } else {
            this.$store.commit('updateVariant', {name: 'status', value: response.data.variant.status})
            this.$router.push({name: 'root.edit', params: {id: response.data.variant.id}})
          }
          this.$message({
            message: response.data.message,
            showClose: true,
            type: 'success'
          })
          this.$parent.$children[0].refresh()
        } else {
          toastr.error(response.data.message)
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
