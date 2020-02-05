<template>
    <!-- Inner container -->
    <div id="modal_large_user" class="modal fade" tabindex="-1">
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
                                            User details
                                            <a class="float-right text-default" data-toggle="collapse" data-target="#demo1">
                                                <i class="icon-circle-down2"></i>
                                            </a>
                                        </legend>
                                        <div class="collapse show" id="demo1">
                                            <div class="form-group row" v-if="user.id !== 0">
                                                <label class="col-lg-3 col-form-label">&nbsp;{{ trans('modals.id') }}</label>
                                                <div class="col-lg-9">
                                                    <input type="text" class="form-control disabled" disabled readonly id='id' name='id' :placeholder="trans('modals.id')" :value="user.id"/>
                                                    <div class="invalid-feedback">
                                                        <strong v-text="errors.get('id')"></strong>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">&nbsp;{{ trans('modals.first_name') }} <span class="text-danger"> *</span></label>
                                                <div class="col-lg-9">
                                                    <input type="text" class="form-control" :class="errors.has('first_name') ? 'is-invalid': ''" id='first_name' name='first_name' :placeholder="trans('modals.first_name')" @input="updateUser"  :value="user.first_name"/>
                                                    <div class="invalid-feedback">
                                                        <strong v-text="errors.get('first_name')"></strong>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">&nbsp;{{ trans('modals.last_name') }}</label>
                                                <div class="col-lg-9">
                                                    <input type="text" class="form-control" :class="errors.has('last_name') ? 'is-invalid': ''" id='last_name' name='last_name' :placeholder="trans('modals.last_name')" @input="updateUser"  :value="user.last_name"/>
                                                    <div class="invalid-feedback">
                                                        <strong v-text="errors.get('last_name')"></strong>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">&nbsp;{{ trans('modals.email') }} <span class="text-danger"> *</span></label>
                                                <div class="col-lg-9">
                                                    <input type="email" class="form-control" :class="errors.has('email') ? 'is-invalid': ''" id='email' name='email' :placeholder="trans('modals.email')" @input="updateUser"  :value="user.email"/>
                                                    <div class="invalid-feedback">
                                                        <strong v-text="errors.get('email')"></strong>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label"> &nbsp;&nbsp;{{ trans('modals.password') }} <span class="text-danger" v-if="parseInt(this.$route.params.id) === 0"> *</span></label>
                                                <div class="col-lg-9">
                                                    <input type="password" class="form-control" :class="errors.has('password') ? 'is-invalid': ''" :placeholder="trans('modals.password')" id="password" name="password" @input="updateUser"  :value="user.password">
                                                    <div class="invalid-feedback">
                                                        <strong v-text="errors.get('password')"></strong>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label"> &nbsp;&nbsp;{{ trans('modals.password_confirm') }} <span class="text-danger" v-if="parseInt(this.$route.params.id) === 0"> *</span></label>
                                                <div class="col-lg-9">
                                                    <input type="password" class="form-control" :class="errors.has('password_confirm') ? 'is-invalid': ''" :placeholder="trans('modals.password_confirm')" id="password_confirm" name="password_confirm" @input="updateUser"  :value="user.password_confirm">
                                                    <div class="invalid-feedback">
                                                        <strong v-text="errors.get('password_confirm')"></strong>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">&nbsp; {{ trans('modals.status') }} </label>
                                                <div class="col-lg-9">
                                                    <el-switch
                                                            @input="updateStatus"
                                                            :value="user.status"
                                                            active-color="#13ce66"
                                                            inactive-color="#ff4949">
                                                    </el-switch>
                                                </div>
                                            </div>
                                            <legend class="font-weight-semibold text-uppercase font-size-sm">
                                                <i class="icon-atom2"></i>
                                                {{ trans('modals.whitelabel') }}
                                                <a class="float-right text-default" data-toggle="collapse" data-target="#demo5">
                                                    <i class="icon-circle-down2"></i>
                                                </a>
                                            </legend>
                                            <div class="collapse show" id="demo5">
                                                <div class="form-group">
                                                    <el-transfer style="width: 100%;margin-left: 5%;"
                                                                 @input="inputWhitelabels"
                                                                 filterable
                                                                 :titles="['Source', 'Target']"
                                                                 :value="user.whitelabels"
                                                                 :data="generateWhitelabels()">
                                                    </el-transfer>
                                                    <div class="help-block text-danger" v-if="errors.has('whitelabels')">
                                                        <strong v-text="errors.get('whitelabels')"></strong>
                                                    </div>
                                                </div>
                                            </div>
                                            <legend class="font-weight-semibold text-uppercase font-size-sm">
                                                <i class="icon-delicious"></i>
                                                {{ trans('modals.roles') }}
                                                <a class="float-right text-default" data-toggle="collapse" data-target="#demo6">
                                                    <i class="icon-circle-down2"></i>
                                                </a>
                                            </legend>
                                            <div class="collapse show" id="demo6">
                                                <div class="form-group">
                                                    <el-transfer style="width: 100%;margin-left: 5%;"
                                                                 @input="inputRoles"
                                                                 filterable
                                                                 :titles="['Source', 'Target']"
                                                                 :value="user.roles"
                                                                 :data="generateRoles()">
                                                    </el-transfer>
                                                    <div class="help-block text-danger" v-if="errors.has('roles')">
                                                        <strong v-text="errors.get('roles')"></strong>
                                                    </div>
                                                </div>
                                            </div>
                                            <legend class="font-weight-semibold text-uppercase font-size-sm">
                                                <i class="icon-statistics"></i>
                                                {{ trans('modals.dashboard') }}
                                                <a class="float-right text-default" data-toggle="collapse" data-target="#demo7">
                                                    <i class="icon-circle-down2"></i>
                                                </a>
                                            </legend>
                                            <div class="collapse show" id="demo7">
                                                <div class="form-group">
                                                    <el-transfer style="width: 100%;margin-left: 5%;"
                                                                 @input="inputDashboards"
                                                                 filterable
                                                                 :titles="['Source', 'Target']"
                                                                 :value="user.dashboards"
                                                                 :data="generateDashboards()">
                                                    </el-transfer>
                                                    <div class="help-block text-danger" v-if="errors.has('dashboards')">
                                                        <strong v-text="errors.get('dashboards')"></strong>
                                                    </div>
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
                            <vue-table :options="user.logs"></vue-table>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-danger btn-sm" data-dismiss="modal"><i class="icon-cancel-circle2 mr-1"></i> {{ trans('button.close') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /inner container -->
</template>

<script>
  import Vuex from 'vuex'
  import { Errors } from '../../../../../../../../../resources/assets/js/utils/errors'
  import VueTable from '../../../../../../../../../resources/assets/js/utils/Table.vue'
  export default {
    name: 'EditSellerComponent',
    components: { VueTable },
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
        this.EditUser(parseInt(this.$route.params.id))
      }
    },
    computed: {
      ...Vuex.mapGetters({
        user: 'user',
        currentUser: 'currentUser'
      }),
      can_logs () {
        return this.hasPermissionTo('logs-user')
      },
      is_edit () {
        return this.user.id !== 0
      }
    },
    methods: {
      ...Vuex.mapActions({
        loadUser: 'loadLoggedUser',
        addUser: 'addUser'
      }),
      inputWhitelabels (value) {
        this.$store.commit('updateUser', {name: 'whitelabels', value: value})
      },
      inputRoles (value) {
        this.$store.commit('updateUser', {name: 'roles', value: value})
      },
      inputDashboards (value) {
        this.$store.commit('updateUser', {name: 'dashboards', value: value})
      },
      updateStatus (value) {
        this.$store.commit('updateUser', {name: 'status', value: value})
      },
      updateConfirmationEmail (value) {
        this.$store.commit('updateUser', {name: 'confirmation_email', value: value})
      },
      updateConfirmed (value) {
        this.$store.commit('updateUser', {name: 'confirmed', value: value})
      },
      generateWhitelabels () {
        let data = []
        if (this.user.hasOwnProperty('whitelabelsList')) {
          this.user['whitelabelsList'].forEach((whitelabel, index) => {
            data.push({
              label: whitelabel['display_name'],
              key: whitelabel['id']
            })
          })
        }

        return data
      },
      generateRoles () {
        let data = []
        if (this.user.hasOwnProperty('rolesList')) {
          this.user['rolesList'].forEach((role, index) => {
            data.push({
              label: role['name'],
              key: role['id']
            })
          })
        }

        return data
      },
      generateDashboards () {
        let data = []
        if (this.user.hasOwnProperty('dashboardsList')) {
          this.user['dashboardsList'].forEach((dashboard, index) => {
            data.push({
              label: dashboard['name'],
              key: dashboard['id']
            })
          })
        }

        return data
      },
      updateUser (e) {
        if (e.target.value !== null) {
          this.$store.commit('updateUser', {name: e.target.name, value: e.target.value})
        }
      },
      hasPermissionTo (permission) {
        return this.currentUser.hasOwnProperty('permissions') && this.currentUser.permissions[permission]
      },
      loadModal () {
        let id = parseInt(this.$route.params.id)
        $('#modal_large_user').on('hidden.bs.modal', () => {
          this.$router.push({name: 'root'})
        })

        if (id === 0) {
          this.CreateUser()
        } else {
          this.EditUser(id)
        }
      },
      CreateUser () {
        this.$store.dispatch('block', {element: 'usersComponent', load: true})
        this.$http.get(window.laroute.route('admin.users.create'))
          .then(this.onLoadUserSuccess)
          .catch(this.onFailed)
          .then(() => {
            this.$store.dispatch('block', {element: 'usersComponent', load: false})
          })
      },
      EditUser (id) {
        this.$store.dispatch('block', {element: 'usersComponent', load: true})
        this.$http.get(window.laroute.route('admin.users.edit', {id: id}))
          .then(this.onLoadUserSuccess)
          .catch(this.onFailed)
          .then(() => {
            this.$store.dispatch('block', {element: 'usersComponent', load: false})
          })
      },
      onLoadUserSuccess (response) {
        if (response.data.hasOwnProperty('success') && response.data.success === true) {
          this.addUser(response.data.user)
          if (!($('#modal_large_user').data('bs.modal') || {}).isShown) {
            $('#modal_large_user').modal('show')
          }
        } else {
          this.$notify.error({ title: 'Failed', message: response.data.message })
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
        this.$store.dispatch('block', {element: 'usersComponent', load: true})
        this.$http.put(window.laroute.route('admin.users.store'), this.user)
          .then(this.onSubmitSuccess)
          .catch(this.onFailed)
          .then(() => {
            this.$store.dispatch('block', {element: 'usersComponent', load: false})
          })
      },
      onSubmitUpdate (id) {
        this.$store.dispatch('block', {element: 'usersComponent', load: true})
        this.$http.put(window.laroute.route('admin.users.update', {id: id}), this.user)
          .then(this.onSubmitSuccess)
          .catch(this.onFailed)
          .then(() => {
            this.$store.dispatch('block', {element: 'usersComponent', load: false})
          })
      },
      onSubmitSuccess (response) {
        if (response.data.hasOwnProperty('success') && response.data.success === true) {
          if (this.close) {
            $('#modal_large_user').modal('hide')
            this.$router.push({name: 'root'})
          } else {
            this.$router.push({name: 'root.edit', params: {id: response.data.user.id}})
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
