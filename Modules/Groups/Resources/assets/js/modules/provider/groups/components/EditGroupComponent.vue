<template>
    <!-- Large modal -->
    <div id="modal_large_group" class="modal fade" tabindex="-1">
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
                                            Group details
                                            <a class="float-right text-default" data-toggle="collapse" data-target="#demo1">
                                                <i class="icon-circle-down2"></i>
                                            </a>
                                        </legend>
                                        <div class="collapse show" id="demo1">
                                            <div class="form-group row" v-if="group.id !== 0">
                                                <label class="col-lg-3 col-form-label">&nbsp;{{ trans('modals.id') }}</label>
                                                <div class="col-lg-9">
                                                    <input type="text" class="form-control disabled" disabled readonly id='id' name='id' :placeholder="trans('modals.id')" :value="group.id"/>
                                                    <div class="invalid-feedback">
                                                        <strong v-text="errors.get('id')"></strong>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">&nbsp;{{ trans('modals.name') }} <span class="text-danger"> *</span></label>
                                                <div class="col-lg-9">
                                                    <input type="text" class="form-control" :class="errors.has('name') ? 'is-invalid': ''" id='name' name='name' :placeholder="trans('modals.name')" @input="updateGroup"  :value="group.name"/>
                                                    <div class="invalid-feedback">
                                                        <strong v-text="errors.get('name')"></strong>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">&nbsp;{{ trans('modals.display_name') }} <span class="text-danger"> *</span></label>
                                                <div class="col-lg-9">
                                                    <input type="text" class="form-control" :class="errors.has('display_name') ? 'is-invalid': ''" id='display_name' name='display_name' :placeholder="trans('modals.display_name')" @input="updateGroup"  :value="group.display_name"/>
                                                    <div class="invalid-feedback">
                                                        <strong v-text="errors.get('display_name')"></strong>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">&nbsp;{{ trans('modals.owner') }}</label>
                                                <div class="col-lg-9">
                                                    <input type="text" class="form-control"  id='owner' disabled readonly :placeholder="trans('modals.owner')"  :value="group.owner"/>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">&nbsp;{{ trans('modals.whitelabel') }}</label>
                                                <div class="col-lg-9">
                                                    <input type="text" class="form-control"  id='whitelabel' disabled readonly :placeholder="trans('modals.whitelabel')"  :value="getGroup('whitelabel', 'display_name')"/>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">&nbsp; {{ trans('modals.users') }} <span class="text-danger"> *</span></label>
                                                <div class="col-lg-9">
                                                    <el-transfer style="width: 100%;"
                                                                 @input="inputUsers"
                                                                 filterable
                                                                 :titles="['Source', 'Target']"
                                                                 :value="group.users"
                                                                 :data="generateUsers()">
                                                    </el-transfer>
                                                    <div class="help-block text-danger" v-if="errors.has('users')">
                                                        <strong v-text="errors.get('users')"></strong>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">&nbsp; {{ trans('modals.description') }}</label>
                                                <div class="col-lg-9">
                                                    <textarea class="form-control" :class="errors.has('description') ? 'is-invalid': ''" rows="5" id='description' name='description' :placeholder="trans('modals.description')" @input="updateGroup"  :value="group.description"></textarea>
                                                    <div class="invalid-feedback">
                                                        <strong v-text="errors.get('description')"></strong>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">&nbsp; {{ trans('modals.status') }} </label>
                                                <div class="col-lg-9">
                                                    <el-switch
                                                            @input="updateStatus"
                                                            :value="group.status"
                                                            active-color="#13ce66"
                                                            inactive-color="#ff4949">
                                                    </el-switch>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">&nbsp; {{ trans('modals.current') }} </label>
                                                <div class="col-lg-9">
                                                    <el-switch
                                                            @input="updateCurrent"
                                                            :value="group.current"
                                                            active-color="#13ce66"
                                                            inactive-color="#ff4949">
                                                    </el-switch>
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
                            </form>                        </div>
                    </div>

                    <div class="tab-pane fade" id="highlighted-justified-tab2" v-if="can_logs">
                        <div class="modal-body">
                            <vue-table :options="group.logs"></vue-table>
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
        this.EditGroup(parseInt(this.$route.params.id))
      }
    },
    computed: {
      ...Vuex.mapGetters({
        group: 'group',
        user: 'currentUser'
      }),
      can_logs () {
        return !this.deleted && this.hasPermissionTo('logs-group')
      }
    },
    methods: {
      ...Vuex.mapActions({
        addGroup: 'addGroup'
      }),
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
          this.$store.commit('updateGroup', {name: e.target.name, value: e.target.value})
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
        $('#modal_large_group').on('hidden.bs.modal', () => {
          this.$router.push({name: 'root'})
        })

        if (id === 0) {
          this.CreateGroup(parseInt(this.$route.params.whitelabel_id))
        } else {
          this.EditGroup(id)
        }
      },
      CreateGroup (whitelabelId) {
        this.$store.dispatch('block', {element: 'groupsComponent', load: true})
        this.$http.get(window.laroute.route('admin.groups.create', {whitelabelId: whitelabelId}))
          .then(this.onLoadGroupSuccess)
          .catch(this.onFailed)
          .then(() => {
            this.$store.dispatch('block', {element: 'groupsComponent', load: false})
          })
      },
      EditGroup (id) {
        this.$store.dispatch('block', {element: 'groupsComponent', load: true})
        this.$http.get(window.laroute.route('admin.groups.edit', {id: id}))
          .then(this.onLoadGroupSuccess)
          .catch(this.onFailed)
          .then(() => {
            this.$store.dispatch('block', {element: 'groupsComponent', load: false})
          })
      },
      onLoadGroupSuccess (response) {
        if (response.data.hasOwnProperty('success') && response.data.success === true) {
          this.addGroup(response.data.group)
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
        this.$store.dispatch('block', {element: 'groupsComponent', load: true})
        this.$http.put(window.laroute.route('admin.groups.store'), this.group)
          .then(this.onSubmitSuccess)
          .catch(this.onFailed)
          .then(() => {
            this.$store.dispatch('block', {element: 'groupsComponent', load: false})
          })
      },
      onSubmitUpdate (id) {
        this.$store.dispatch('block', {element: 'groupsComponent', load: true})
        this.$http.put(window.laroute.route('admin.groups.update', {id: id}), this.group)
          .then(this.onSubmitSuccess)
          .catch(this.onFailed)
          .then(() => {
            this.$store.dispatch('block', {element: 'groupsComponent', load: false})
          })
      },
      onSubmitSuccess (response) {
        if (response.data.hasOwnProperty('success') && response.data.success === true) {
          if (this.close) {
            $('#modal_large_group').modal('hide')
            this.$router.push({name: 'root'})
          } else {
            this.$router.push({name: 'root.edit', params: {id: response.data.group.id}})
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
