<template>
    <!-- Inner container -->
    <div id="modal_large_user" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="icon-menu7 mr-2"></i> &nbsp;Modal with icons</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <ul class="nav nav-tabs nav-tabs-highlight nav-justified">
                    <li class="nav-item" v-if="can_logs"><a href="#highlighted-justified-tab1" class="nav-link active" data-toggle="tab"><i class="icon-pencil6 mr-2"></i> {{ trans('modals.user') }}</a></li>
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
                                                <label class="col-lg-3 col-form-label">&nbsp;{{ trans('modals.name') }} <span class="text-danger"> *</span></label>
                                                <div class="col-lg-9">
                                                    <input type="text" class="form-control" :class="errors.has('first_name') ? 'is-invalid': ''" id='first_name' name='first_name' :placeholder="trans('modals.name')" @input="updateUser"  :value="user.first_name"/>
                                                    <div class="invalid-feedback">
                                                        <strong v-text="errors.get('first_name')"></strong>
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
                                                <label class="col-lg-3 col-form-label">&nbsp;{{ trans('validation.attributes.backend.access.users.associated_whitelabels') }}</label>
                                                <div class="col-lg-9">
                                                    <input type="text" class="form-control"  id='whitelabel' name='whitelabel' :placeholder="trans('validation.attributes.backend.access.users.associated_whitelabels')"   :value="getWhitelabel('whitelabel', 'display_name')" disabled readonly/>
                                                    <div class="invalid-feedback">
                                                        <strong v-text="errors.get('whitelabel')"></strong>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">&nbsp; {{ trans('modals.confirmed') }} </label>
                                                <div class="col-lg-9">
                                                    <el-switch
                                                            @input="updateConfirmed"
                                                            :value="user.confirmed"
                                                            active-color="#13ce66"
                                                            inactive-color="#ff4949">
                                                    </el-switch>
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
                                                <i class="icon-thumbs-up3"></i>
                                                {{ trans('validation.attributes.backend.access.users.groups') }}
                                                <a class="float-right text-default" data-toggle="collapse" data-target="#demo5">
                                                    <i class="icon-circle-down2"></i>
                                                </a>
                                            </legend>
                                            <div class="collapse show" id="demo5">
                                                <div class="form-group">
                                                    <el-transfer style="width: 100%;margin-left: 5%;"
                                                                 @input="inputGroups"
                                                                 filterable
                                                                 :titles="['Source', 'Target']"
                                                                 :value="user.groups"
                                                                 :data="generateGroups()">
                                                    </el-transfer>
                                                    <div class="help-block text-danger" v-if="errors.has('groups')">
                                                        <strong v-text="errors.get('groups')"></strong>
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
  import { Errors } from '../../../../../../../../../../resources/assets/js/utils/errors'
  import VueTable from '../../../../../../../../../../resources/assets/js/utils/Table.vue'
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
    },
    computed: {
      ...Vuex.mapGetters({
        user: 'user',
        currentUser: 'currentUser'
      }),
      can_logs () {
        return this.hasPermissionTo('logs-user')
      }
    },
    methods: {
      ...Vuex.mapActions({
        loadUser: 'loadLoggedUser',
        addUser: 'addUser'
      }),
      inputGroups (value) {
        this.$store.commit('updateUser', {name: 'groups', value: value})
      },
      updateStatus (value) {
        this.$store.commit('updateUser', {name: 'status', value: value})
      },
      updateConfirmed (value) {
        this.$store.commit('updateUser', {name: 'confirmed', value: value})
      },
      generateGroups () {
        let data = []
        if (this.user.hasOwnProperty('groupsList')) {
          this.user['groupsList'].forEach((group, index) => {
            data.push({
              label: group['name'],
              key: group['id']
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
          this.CreateUser(parseInt(this.$route.params.whitelabel_id))
        } else {
          this.EditUser(id)
        }
      },
      CreateUser (whitelabelId) {
        this.$store.dispatch('block', {element: 'usersComponent', load: true})
        this.$http.get(window.laroute.route('admin.sellers.create', {whitelabelId: whitelabelId}))
          .then(this.onLoadUserSuccess)
          .catch(this.onFailed)
          .then(() => {
            this.$store.dispatch('block', {element: 'usersComponent', load: false})
          })
      },
      EditUser (id) {
        this.$store.dispatch('block', {element: 'usersComponent', load: true})
        this.$http.get(window.laroute.route('admin.sellers.edit', {id: id}))
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
        this.$http.put(window.laroute.route('admin.sellers.store'), this.user)
          .then(this.onSubmitSuccess)
          .catch(this.onFailed)
          .then(() => {
            this.$store.dispatch('block', {element: 'usersComponent', load: false})
          })
      },
      onSubmitUpdate (id) {
        this.$store.dispatch('block', {element: 'usersComponent', load: true})
        this.$http.put(window.laroute.route('admin.sellers.update', {id: id}), this.user)
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
            this.$router.push({name: 'root.seller', params: {id: response.data.user.id}})
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
      getWhitelabel (key, value) {
        return (this.user.hasOwnProperty(key)) ? this.user[key][value] : ''
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
