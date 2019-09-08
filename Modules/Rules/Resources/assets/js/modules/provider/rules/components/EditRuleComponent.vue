<template>
    <!-- Large modal -->
    <div id="modal_large_rule" class="modal fade" tabindex="-1">
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
                                            Rule details
                                            <a class="float-right text-default" data-toggle="collapse" data-target="#demo1">
                                                <i class="icon-circle-down2"></i>
                                            </a>
                                        </legend>
                                        <div class="collapse show" id="demo1">
                                            <div class="form-group row" v-if="rule.id !== 0">
                                                <label class="col-lg-3 col-form-label">&nbsp;{{ trans('modals.id') }}</label>
                                                <div class="col-lg-9">
                                                    <input type="text" class="form-control disabled" disabled readonly id='id' name='id' :placeholder="trans('modals.id')" :value="rule.id"/>
                                                    <div class="invalid-feedback">
                                                        <strong v-text="errors.get('id')"></strong>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">&nbsp;{{ trans('modals.type') }} <span class="text-danger"> *</span></label>
                                                <div class="col-lg-9">
                                                    <el-radio-group :value="rule.type" name="type" @input="updateRuleType" size="medium" style="width: 100%;">
                                                        <el-radio-button label="manuel"></el-radio-button>
                                                        <el-radio-button label="auto"></el-radio-button>
                                                        <el-radio-button label="mix"></el-radio-button>
                                                    </el-radio-group>
                                                    <div class="help-block text-danger" v-if="errors.has('type')">
                                                        <strong v-text="errors.get('type')"></strong>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row" v-if="rule.type === 'mix'">
                                                <label class="col-lg-3 col-form-label">&nbsp;{{ trans('modals.budget') }}</label>
                                                <div class="col-lg-9">
                                                    <input type="number" min="0" step="1" class="form-control" :class="errors.has('budget') ? 'is-invalid': ''" id='budget' name='budget' :placeholder="trans('modals.budget')" @input="updateRule"  :value="rule.budget"/>
                                                    <div class="invalid-feedback">
                                                        <strong v-text="errors.get('budget')"></strong>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row" v-if="rule.type === 'mix'">
                                                <label class="col-lg-3 col-form-label">&nbsp;{{ trans('modals.destination') }}</label>
                                                <div class="col-lg-9">
                                                    <el-tag :key="tag" v-for="tag in rule.destination" closable :disable-transitions="false" @close="handleClose(tag)">
                                                        {{tag}}
                                                    </el-tag>
                                                    <el-input class="input-new-tag" v-if="inputVisible" v-model="inputValue" ref="saveTagInput" size="mini" @keyup.enter.native="handleInputConfirm" @blur="handleInputConfirm">
                                                    </el-input>
                                                    <el-button v-else class="button-new-tag" size="small" @click="showInput">+ {{ trans('modals.destination') }}</el-button>
                                                    <br>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">&nbsp;{{ trans('modals.owner') }}</label>
                                                <div class="col-lg-9">
                                                    <input type="text" class="form-control"  id='user' disabled readonly :placeholder="trans('modals.owner')"  :value="getRule('user', 'full_name')"/>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">&nbsp;{{ trans('modals.whitelabel') }}</label>
                                                <div class="col-lg-9">
                                                    <input type="text" class="form-control"  id='whitelabel' disabled readonly :placeholder="trans('modals.whitelabel')"  :value="getRule('whitelabel', 'display_name')"/>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">&nbsp; {{ trans('modals.status') }} </label>
                                                <div class="col-lg-9">
                                                    <el-switch
                                                            @input="updateStatus"
                                                            :value="rule.status"
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
                            <vue-table :options="rule.logs"></vue-table>
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
<style>
    .el-tag + .el-tag {
        margin-left: 10px !important;
    }
    .button-new-tag {
        margin-left: 10px !important;
        height: 32px !important;
        line-height: 30px !important;
        padding-top: 0 !important;
        padding-bottom: 0 !important;
    }
    .input-new-tag {
        width: 90px !important;
        margin-left: 10px !important;
        vertical-align: bottom !important;
    }
</style>
<script>
  import Vuex from 'vuex'
  import { Errors } from '../../../../../../../../../resources/assets/js/utils/errors'
  import VueTable from '../../../../../../../../../resources/assets/js/utils/Table.vue'
  import DateComponent from './DateComponent'
  import toastr from 'toastr'
  export default {
    name: 'EditRuleComponent',
    components: { VueTable, DateComponent },
    data () {
      return {
        // eslint-disable-next-line
        errors: new Errors(),
        close: false,
        inputVisible: false,
        inputValue: ''
      }
    },
    mounted () {
      this.loadModal()
    },
    watch: {
      '$route.params.id' () {
        this.EditRule(parseInt(this.$route.params.id))
      }
    },
    computed: {
      ...Vuex.mapGetters({
        rule: 'rule',
        user: 'currentUser'
      }),
      can_logs () {
        return !this.deleted && this.hasPermissionTo('logs-rule')
      }
    },
    methods: {
      ...Vuex.mapActions({
        addRule: 'addRule'
      }),
      hasPermissionTo (permission) {
        return this.user.hasOwnProperty('permissions') && this.user.permissions[permission]
      },
      hasRole (permission) {
        return this.user.hasOwnProperty('roles') && this.user.roles[permission]
      },
      generateUsers () {
        let data = []
        if (this.rule.hasOwnProperty('usersList')) {
          this.rule['usersList'].forEach((user, index) => {
            data.push({
              label: user['name'],
              key: user['id']
            })
          })
        }
  
        return data
      },
      inputUsers (value) {
        this.$store.commit('updateRule', {name: 'users', value: value})
      },
      showInput () {
        this.inputVisible = true
        this.$nextTick(_ => {
          this.$refs.saveTagInput.$refs.input.focus()
        })
      },
      handleInputConfirm () {
        let inputValue = this.inputValue
        if (inputValue) {
          this.$store.commit('updateRuleDestination', {name: 'description', value: inputValue})
        }
        this.inputVisible = false
        this.inputValue = ''
      },
      handleClose (tag) {
        this.$store.commit('updateTemplateRemoveTags', tag)
      },
      getRule (key, value) {
        return (this.rule.hasOwnProperty(key)) ? this.rule[key][value] : ''
      },
      updateRule (e) {
        if (e.target.value !== null) {
          this.$store.commit('updateRule', {name: e.target.name, value: e.target.value})
        }
      },
      updateRuleType (value) {
        if (value !== null) {
          this.$store.commit('updateRule', {name: 'type', value: value})
        }
      },
      updateStatus (value) {
        this.$store.commit('updateRule', {name: 'status', value: value})
      },
      updateCurrent (value) {
        this.$store.commit('updateRule', {name: 'current', value: value})
      },
      loadModal () {
        let id = parseInt(this.$route.params.id)
        $('#modal_large_rule').on('hidden.bs.modal', () => {
          this.$router.push({name: 'root'})
        })

        if (id === 0) {
          this.CreateRule(parseInt(this.$route.params.whitelabel_id))
        } else {
          this.EditRule(id)
        }
      },
      CreateRule (whitelabelId) {
        this.$store.dispatch('block', {element: 'rulesComponent', load: true})
        this.$http.get(window.laroute.route('admin.rules.create', {whitelabelId: whitelabelId}))
          .then(this.onLoadRuleSuccess)
          .catch(this.onFailed)
          .then(() => {
            this.$store.dispatch('block', {element: 'rulesComponent', load: false})
          })
      },
      EditRule (id) {
        this.$store.dispatch('block', {element: 'rulesComponent', load: true})
        this.$http.get(window.laroute.route('admin.rules.edit', {id: id}))
          .then(this.onLoadRuleSuccess)
          .catch(this.onFailed)
          .then(() => {
            this.$store.dispatch('block', {element: 'rulesComponent', load: false})
          })
      },
      onLoadRuleSuccess (response) {
        if (response.data.hasOwnProperty('success') && response.data.success === true) {
          this.addRule(response.data.rule)
          if (!($('#modal_large_rule').data('bs.modal') || {}).isShown) {
            $('#modal_large_rule').modal('show')
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
        this.$store.dispatch('block', {element: 'rulesComponent', load: true})
        this.$http.put(window.laroute.route('admin.rules.store'), this.rule)
          .then(this.onSubmitSuccess)
          .catch(this.onFailed)
          .then(() => {
            this.$store.dispatch('block', {element: 'rulesComponent', load: false})
          })
      },
      onSubmitUpdate (id) {
        this.$store.dispatch('block', {element: 'rulesComponent', load: true})
        this.$http.put(window.laroute.route('admin.rules.update', {id: id}), this.rule)
          .then(this.onSubmitSuccess)
          .catch(this.onFailed)
          .then(() => {
            this.$store.dispatch('block', {element: 'rulesComponent', load: false})
          })
      },
      onSubmitSuccess (response) {
        if (response.data.hasOwnProperty('success') && response.data.success === true) {
          if (this.close) {
            $('#modal_large_rule').modal('hide')
            this.$router.push({name: 'root'})
          } else {
            this.$router.push({name: 'root.edit', params: {id: response.data.rule.id}})
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
