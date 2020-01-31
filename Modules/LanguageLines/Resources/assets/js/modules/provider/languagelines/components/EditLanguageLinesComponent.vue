<template>
    <!-- Large modal -->
    <div id="modal_large_languagelines" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="icon-menu7 mr-2"></i> &nbsp;Modal with icons</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <ul class="nav nav-tabs nav-tabs-highlight nav-justified">
                    <li class="nav-item" v-if="can_logs"><a href="#highlighted-justified-tab1" class="nav-link active" data-toggle="tab"><i class="icon-pencil6 mr-2"></i> {{ trans('modals.group') }}</a></li>
                    <li class="nav-item" v-if="can_logs"><a href="#highlighted-justified-tab2" class="nav-link" data-toggle="tab"><i class="icon-file-text mr-2"></i> {{ trans('modals.logs') }}</a></li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane fade show active" id="highlighted-justified-tab1">
                        <div class="card-body">
                            <form action="#" @submit.prevent="onSubmit" @keydown="errors.clear($event.target.name)">
                                <div class="modal-body">
                                    <fieldset>
                                        <legend class="font-weight-semibold text-uppercase font-size-sm">
                                            <i class="icon-collaboration mr-2"></i>
                                            LanguageLine details
                                            <a class="float-right text-default" data-toggle="collapse" data-target="#demo1">
                                                <i class="icon-circle-down2"></i>
                                            </a>
                                        </legend>
                                        <div class="collapse show" id="demo1">
                                            <div class="form-group row" v-if="languageline.id !== 0">
                                                <label class="col-lg-3 col-form-label">&nbsp;{{ trans('modals.id') }}</label>
                                                <div class="col-lg-9">
                                                    <input type="text" class="form-control disabled" disabled readonly id='id' name='id' :placeholder="trans('modals.id')" :value="languageline.id"/>
                                                    <div class="invalid-feedback">
                                                        <strong v-text="errors.get('id')"></strong>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">&nbsp;{{ trans('modals.locale') }} <span class="text-danger"> *</span></label>
                                                <div class="col-lg-9">
                                                    <input type="text" class="form-control" :class="errors.has('locale') ? 'is-invalid': ''" id='locale' name='locale' :placeholder="trans('modals.locale')" @input="updateGroup"  :value="languageline.locale"/>
                                                    <div class="invalid-feedback">
                                                        <strong v-text="errors.get('locale')"></strong>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">&nbsp;{{ trans('modals.description') }} <span class="text-danger"> *</span></label>
                                                <div class="col-lg-9">
                                                    <input type="text" class="form-control" :class="errors.has('description') ? 'is-invalid': ''" id='description' name='description' :placeholder="trans('modals.description')" @input="updateGroup"  :value="languageline.description"/>
                                                    <div class="invalid-feedback">
                                                        <strong v-text="errors.get('description')"></strong>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">&nbsp;{{ trans('modals.group') }} <span class="text-danger"> *</span></label>
                                                <div class="col-lg-9">
                                                    <input type="text" class="form-control" :class="errors.has('group') ? 'is-invalid': ''" id='group' name='group' :placeholder="trans('modals.group')" @input="updateGroup"  :value="languageline.group"/>
                                                    <div class="invalid-feedback">
                                                        <strong v-text="errors.get('group')"></strong>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">&nbsp;{{ trans('modals.key') }} <span class="text-danger"> *</span></label>
                                                <div class="col-lg-9">
                                                    <input type="text" class="form-control" :class="errors.has('key') ? 'is-invalid': ''" id='key' name='key' :placeholder="trans('modals.key')" @input="updateGroup"  :value="languageline.key"/>
                                                    <div class="invalid-feedback">
                                                        <strong v-text="errors.get('key')"></strong>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">&nbsp;{{ trans('modals.text') }} <span class="text-danger"> *</span></label>
                                                <div class="col-lg-9">
                                                    <input type="text" class="form-control" :class="errors.has('text') ? 'is-invalid': ''" id='text' name='text' :placeholder="trans('modals.text')" @input="updateGroup"  :value="languageline.text"/>
                                                    <div class="invalid-feedback">
                                                        <strong v-text="errors.get('text')"></strong>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row"  v-if="languageline.whitelabel_id === null">
                                                <label class="col-lg-3 col-form-label">&nbsp; {{ trans('modals.default') }} </label>
                                                <div class="col-lg-9">
                                                    <el-switch
                                                            @input="updateDefault"
                                                            :value="languageline.default"
                                                            active-color="#13ce66"
                                                            inactive-color="#ff4949">
                                                    </el-switch>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">&nbsp; {{ trans('modals.licence') }} </label>
                                                <div class="col-lg-9">
                                                    <el-radio-group :value="languageline.licence" @input="updateLicence">
                                                        <el-radio-button label="0">Light</el-radio-button>
                                                        <el-radio-button label="1">Basic</el-radio-button>
                                                        <el-radio-button label="2">Premium</el-radio-button>
                                                        <el-radio-button label="3">Mix</el-radio-button>
                                                    </el-radio-group>
                                                </div>
                                            </div>
                                            <div class="form-group row" v-if="hasRole('Administrator')">
                                                <label class="col-lg-3 col-form-label">&nbsp;{{ trans('modals.whitelabel') }}</label>
                                                <div class="col-lg-9">
                                                    <el-select :value="languageline.whitelabel_id" :placeholder="trans('tables.whitelabel')" @input="doWhitelabel" style="width: 100%;">
                                                        <el-option style="width: 100%;"
                                                                   v-for="item in whitelabels"
                                                                   :key="item.id"
                                                                   :label="item.name"
                                                                   :value="item.id">
                                                        </el-option>
                                                    </el-select>
                                                </div>
                                            </div>
                                        </div>

                                    </fieldset>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline bg-purple-600 text-purple-600 border-purple-600 btn-sm" v-on:click="onDuplicate"><i class="icon-checkmark-circle mr-1"></i>{{ trans('modals.duplicate') }}</button>
                                    <button type="submit" class="btn btn-outline bg-teal-600 text-teal-600 border-teal-600 btn-sm" v-on:click="close = false"><i class="icon-checkmark-circle mr-1"></i>{{ trans('button.save') }}</button>
                                    <button type="submit" class="btn btn-outline bg-teal-400 text-teal-400 border-teal-400 btn-sm" v-on:click="close = true"><i class="icon-checkmark-circle mr-1"></i>{{ trans('button.save_and_close') }}</button>
                                    <button type="button" class="btn btn-outline-danger btn-sm" data-dismiss="modal"><i class="icon-cancel-circle2 mr-1"></i> {{ trans('button.close') }}</button>
                                </div>
                            </form>                        </div>
                    </div>

                    <div class="tab-pane fade" id="highlighted-justified-tab2" v-if="can_logs">
                        <div class="modal-body">
                            <vue-table :options="languageline.logs"></vue-table>
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
  import DateComponent from './DateComponent'
  import toastr from 'toastr'
  export default {
    name: 'EditLanguageLinesComponent',
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
        this.EditGroup(parseInt(this.$route.params.id))
      }
    },
    computed: {
      ...Vuex.mapGetters({
        whitelabels: 'whitelabels',
        group: 'group',
        languageline: 'languageline',
        user: 'currentUser'
      }),
      can_logs () {
        return !this.deleted && this.hasPermissionTo('logs-group')
      }
    },
    methods: {
      ...Vuex.mapActions({
        addGroup: 'addGroup',
        addLanguageline: 'addLanguageline'
      }),
      updateLicence (value) {
        this.$store.commit('updateLanguageLine', {name: 'licence', value: value})
      },
      updateDefault (value) {
        this.$store.commit('updateLanguageLine', {name: 'default', value: value})
      },
      doWhitelabel (value) {
        this.$store.commit('updateLanguageLine', {name: 'whitelabel_id', value: value})
      },
      hasPermissionTo (permission) {
        return this.user.hasOwnProperty('permissions') && this.user.permissions[permission]
      },
      hasRole (permission) {
        return this.user.hasOwnProperty('roles') && this.user.roles[permission]
      },
      generateUsers () {
        let data = []
        if (this.group.hasOwnProperty('usersList')) {
          this.group['usersList'].forEach((user, index) => {
            data.push({
              label: user['name'],
              key: user['id']
            })
          })
        }

        return data
      },
      inputUsers (value) {
        this.$store.commit('updateGroup', {name: 'users', value: value})
      },
      getGroup (key, value) {
        return (this.group.hasOwnProperty(key)) ? this.group[key][value] : ''
      },
      updateGroup (e) {
        if (e.target.value !== null) {
          this.$store.commit('updateLanguageLine', {name: e.target.name, value: e.target.value})
        }
      },
      updateLanguageLine (e) {
        if (e.target.value != null) {
          this.store.commit('updateLanguageLine', {name: e.target.name, value: e.target.value})
        }
      },
      updateStatus (value) {
        this.$store.commit('updateGroup', {name: 'status', value: value})
      },
      updateCurrent (value) {
        this.$store.commit('updateGroup', {name: 'current', value: value})
      },
      loadModal () {
        let id = parseInt(this.$route.params.id)
        $('#modal_large_languagelines').on('hidden.bs.modal', () => {
          this.$router.push({name: 'root'})
        })

        if (id === 0) {
          this.CreateGroup()
        } else {
          this.EditGroup(id)
        }
      },
      CreateGroup () {
        this.$store.dispatch('block', {element: 'languageLinesComponent', load: true})
        this.$http.get(window.laroute.route('provider.language-lines.create'))
          .then(this.onLoadGroupSuccess)
          .catch(this.onFailed)
          .then(() => {
            this.$store.dispatch('block', {element: 'languageLinesComponent', load: false})
          })
      },
      EditGroup (id) {
        this.$store.dispatch('block', {element: 'languageLinesComponent', load: true})
        this.$http.get(window.laroute.route('provider.language-lines.edit', {id: id}))
          .then(this.onLoadGroupSuccess)
          .catch(this.onFailed)
          .then(() => {
            this.$store.dispatch('block', {element: 'languageLinesComponent', load: false})
          })
      },
      onLoadGroupSuccess (response) {
        if (response.data.hasOwnProperty('success') && response.data.success === true) {
          this.addLanguageline(response.data.languageline)
          if (!($('#modal_large_languagelines').data('bs.modal') || {}).isShown) {
            $('#modal_large_languagelines').modal('show')
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
        this.$store.dispatch('block', {element: 'languageLinesComponent', load: true})
        this.$http.put(window.laroute.route('provider.language-lines.store'), this.languageline)
          .then(this.onSubmitSuccess)
          .catch(this.onFailed)
          .then(() => {
            this.$store.dispatch('block', {element: 'languageLinesComponent', load: false})
          })
      },
      onDuplicate () {
        this.$store.dispatch('block', {element: 'languageLinesComponent', load: true})
        this.$http.post(window.laroute.route('provider.language-lines.duplicate'), this.languageline)
          .then(this.onSubmitSuccess)
          .catch(this.onFailed)
          .then(() => {
            this.$store.dispatch('block', {element: 'languageLinesComponent', load: false})
          })
      },
      onSubmitUpdate (id) {
        this.$store.dispatch('block', {element: 'languageLinesComponent', load: true})
        this.$http.put(window.laroute.route('provider.language-lines.update', {id: id}), this.languageline)
          .then(this.onSubmitSuccess)
          .catch(this.onFailed)
          .then(() => {
            this.$store.dispatch('block', {element: 'languageLinesComponent', load: false})
          })
      },
      onSubmitSuccess (response) {
        if (response.data.hasOwnProperty('success') && response.data.success === true) {
          if (this.close) {
            $('#modal_large_languagelines').modal('hide')
            this.$router.push({name: 'root'})
          } else {
            this.$router.push({name: 'root.edit', params: {id: response.data.languageline.id}})
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
