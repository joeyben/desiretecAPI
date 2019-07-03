<template>
    <!-- Large modal -->
    <div id="modal_large_footer" class="modal fade" tabindex="-1">
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
                                            Footer details
                                            <a class="float-right text-default" data-toggle="collapse" data-target="#demo1">
                                                <i class="icon-circle-down2"></i>
                                            </a>
                                        </legend>
                                        <div class="collapse show" id="demo1">
                                            <div class="form-group row" v-if="footer.id !== 0">
                                                <label class="col-lg-3 col-form-label">&nbsp;{{ trans('modals.id') }}</label>
                                                <div class="col-lg-9">
                                                    <input type="text" class="form-control disabled" disabled readonly id='id' name='id' :placeholder="trans('modals.id')" :value="footer.id"/>
                                                    <div class="invalid-feedback">
                                                        <strong v-text="errors.get('id')"></strong>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">&nbsp;{{ trans('modals.name') }} <span class="text-danger"> *</span></label>
                                                <div class="col-lg-9">
                                                    <input type="text" class="form-control" :class="errors.has('name') ? 'is-invalid': ''" id='name' name='name' :placeholder="trans('modals.name')" @input="updateFooter"  :value="footer.name"/>
                                                    <div class="invalid-feedback">
                                                        <strong v-text="errors.get('name')"></strong>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">&nbsp;{{ trans('modals.url') }} <span class="text-danger"> *</span></label>
                                                <div class="col-lg-9">
                                                    <input type="text" class="form-control" :class="errors.has('url') ? 'is-invalid': ''" id='url' name='url' :placeholder="trans('modals.url')" @input="updateFooter"  :value="footer.url"/>
                                                    <div class="invalid-feedback">
                                                        <strong v-text="errors.get('url')"></strong>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">&nbsp;{{ trans('modals.position') }} <span class="text-danger"> *</span></label>
                                                <div class="col-lg-9">
                                                    <input type="number" min="1" step="1" class="form-control" :class="errors.has('position') ? 'is-invalid': ''" id='position' name='position' :placeholder="trans('modals.position')" @input="updateFooter"  :value="footer.position"/>
                                                    <div class="invalid-feedback">
                                                        <strong v-text="errors.get('position')"></strong>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label"> &nbsp; {{ trans('modals.group') }}</label>
                                            <div class="col-lg-9">
                                                <el-select :value="footer.whitelabel_id" :placeholder="trans('labels.whitelabel')" size="small" style="width: 100%;" @input="inputWhitelabel">
                                                    <el-option
                                                            v-for="item in footer.whitelabels"
                                                            :key="item.id"
                                                            :label="item.display_name"
                                                            :value="item.id">
                                                        <span style="float: left"> {{ item.display_name }}</span>
                                                    </el-option>
                                                </el-select>
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
                            <vue-table :options="footer.logs"></vue-table>
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
  import toastr from 'toastr'
  export default {
    name: 'EditFooterComponent',
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
        this.EditFooter(parseInt(this.$route.params.id))
      }
    },
    computed: {
      ...Vuex.mapGetters({
        footer: 'footer',
        user: 'currentUser'
      }),
      can_logs () {
        return !this.deleted && this.hasPermissionTo('logs-footer')
      }
    },
    methods: {
      ...Vuex.mapActions({
        addFooter: 'addFooter'
      }),
      inputWhitelabel (value) {
        this.$store.commit('updateFooter', {name: 'whitelabel_id', value: value})
      },
      hasPermissionTo (permission) {
        return this.user.hasOwnProperty('permissions') && this.user.permissions[permission]
      },
      hasRole (permission) {
        return this.user.hasOwnProperty('roles') && this.user.roles[permission]
      },
      generateUsers () {
        let data = []
        if (this.footer.hasOwnProperty('usersList')) {
          this.footer['usersList'].forEach((user, index) => {
            data.push({
              label: user['name'],
              key: user['id']
            })
          })
        }
  
        return data
      },
      inputUsers (value) {
        this.$store.commit('updateFooter', {name: 'users', value: value})
      },
      getFooter (key, value) {
        return (this.footer.hasOwnProperty(key)) ? this.footer[key][value] : ''
      },
      updateFooter (e) {
        if (e.target.value !== null) {
          this.$store.commit('updateFooter', {name: e.target.name, value: e.target.value})
        }
      },
      updateStatus (value) {
        this.$store.commit('updateFooter', {name: 'status', value: value})
      },
      updateCurrent (value) {
        this.$store.commit('updateFooter', {name: 'current', value: value})
      },
      loadModal () {
        let id = parseInt(this.$route.params.id)
        $('#modal_large_footer').on('hidden.bs.modal', () => {
          this.$router.push({name: 'root'})
        })

        if (id === 0) {
          this.CreateFooter(parseInt(this.$route.params.whitelabel_id))
        } else {
          this.EditFooter(id)
        }
      },
      CreateFooter (whitelabelId) {
        this.$store.dispatch('block', {element: 'footersComponent', load: true})
        this.$http.get(window.laroute.route('admin.footers.create', {whitelabelId: whitelabelId}))
          .then(this.onLoadFooterSuccess)
          .catch(this.onFailed)
          .then(() => {
            this.$store.dispatch('block', {element: 'footersComponent', load: false})
          })
      },
      EditFooter (id) {
        this.$store.dispatch('block', {element: 'footersComponent', load: true})
        this.$http.get(window.laroute.route('admin.footers.edit', {id: id}))
          .then(this.onLoadFooterSuccess)
          .catch(this.onFailed)
          .then(() => {
            this.$store.dispatch('block', {element: 'footersComponent', load: false})
          })
      },
      onLoadFooterSuccess (response) {
        if (response.data.hasOwnProperty('success') && response.data.success === true) {
          this.addFooter(response.data.footer)
          if (!($('#modal_large_footer').data('bs.modal') || {}).isShown) {
            $('#modal_large_footer').modal('show')
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
        this.$store.dispatch('block', {element: 'footersComponent', load: true})
        this.$http.put(window.laroute.route('admin.footers.store'), this.footer)
          .then(this.onSubmitSuccess)
          .catch(this.onFailed)
          .then(() => {
            this.$store.dispatch('block', {element: 'footersComponent', load: false})
          })
      },
      onSubmitUpdate (id) {
        this.$store.dispatch('block', {element: 'footersComponent', load: true})
        this.$http.put(window.laroute.route('admin.footers.update', {id: id}), this.footer)
          .then(this.onSubmitSuccess)
          .catch(this.onFailed)
          .then(() => {
            this.$store.dispatch('block', {element: 'footersComponent', load: false})
          })
      },
      onSubmitSuccess (response) {
        if (response.data.hasOwnProperty('success') && response.data.success === true) {
          if (this.close) {
            $('#modal_large_footer').modal('hide')
            this.$router.push({name: 'root'})
          } else {
            this.$router.push({name: 'root.edit', params: {id: response.data.footer.id}})
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
