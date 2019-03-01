<template>
    <!-- Large modal -->
    <div id="modal_large_wish" class="modal fade" tabindex="-1">
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
                                            <i class="icon-check mr-2"></i>
                                            Wish details
                                            <a class="float-right text-default" data-toggle="collapse" data-target="#demo1">
                                                <i class="icon-circle-down2"></i>
                                            </a>
                                        </legend>
                                        <div class="collapse show" id="demo1">
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">&nbsp;{{ trans('modals.title') }} <span class="text-danger"> *</span></label>
                                                <div class="col-lg-9">
                                                    <input type="text" class="form-control" :class="errors.has('title') ? 'is-invalid': ''" id='title' name='title' :placeholder="trans('modals.title')" disabled readonly :value="wish.title"/>
                                                    <div class="invalid-feedback">
                                                        <strong v-text="errors.get('title')"></strong>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">&nbsp; {{ trans('modals.airport') }} <span class="text-danger"> *</span></label>
                                                <div class="col-lg-9">
                                                    <input type="text" class="form-control" :class="errors.has('airport') ? 'is-invalid': ''" id='airport' name='airport' :placeholder="trans('modals.airport')" disabled readonly  :value="wish.airport"/>
                                                    <div class="invalid-feedback">
                                                        <strong v-text="errors.get('airport')"></strong>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">&nbsp; {{ trans('modals.destination') }} <span class="text-danger"> *</span></label>
                                                <div class="col-lg-9">
                                                    <input type="text" class="form-control" :class="errors.has('destination') ? 'is-invalid': ''" id='destination' name='destination' :placeholder="trans('modals.destination')" disabled readonly  :value="wish.destination"/>
                                                    <div class="invalid-feedback">
                                                        <strong v-text="errors.get('destination')"></strong>
                                                    </div>
                                                </div>
                                            </div>
                                            <date-component :date="wish.earliest_start" field="earliest_start" :errors="errors" v-if="wish.hasOwnProperty('earliest_start')"></date-component>
                                            <date-component :date="wish.latest_return" field="latest_return" :errors="errors" v-if="wish.hasOwnProperty('latest_return')"></date-component>
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">&nbsp; {{ trans('modals.adults') }} <span class="text-danger"> *</span></label>
                                                <div class="col-lg-9">
                                                    <el-input-number name='adults' :value="wish.adults" disabled :min="1" :class="errors.has('adults') ? 'is-invalid': ''" style="width: 100%;"></el-input-number>
                                                    <div class="help-block text-danger" v-if="errors.has('adults')">
                                                        <strong v-text="errors.get('adults')"></strong>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">&nbsp; {{ trans('modals.kids') }}</label>
                                                <div class="col-lg-9">
                                                    <el-input-number name='kids' :value="wish.kids" disabled :min="0" :class="errors.has('kids') ? 'is-invalid': ''" style="width: 100%;"></el-input-number>
                                                    <div class="help-block text-danger" v-if="errors.has('kids')">
                                                        <strong v-text="errors.get('kids')"></strong>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">&nbsp; {{ trans('modals.budget') }} <span class="text-danger"> *</span></label>
                                                <div class="col-lg-9">
                                                    <el-input-number name='kids' :value="wish.budget" disabled :min="0" :class="errors.has('budget') ? 'is-invalid': ''" style="width: 100%;"></el-input-number>
                                                    <div class="help-block text-danger" v-if="errors.has('budget')">
                                                        <strong v-text="errors.get('budget')"></strong>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">&nbsp;{{ trans('modals.owner') }}</label>
                                                <div class="col-lg-9">
                                                    <input type="text" class="form-control"  id='owner' disabled readonly :placeholder="trans('modals.owner')"  :value="getWish('owner', 'full_name')"/>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">&nbsp;{{ trans('modals.whitelabel') }}</label>
                                                <div class="col-lg-9">
                                                    <input type="text" class="form-control"  id='whitelabel' disabled readonly :placeholder="trans('modals.whitelabel')"  :value="getWish('whitelabel', 'display_name')"/>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label"> &nbsp; {{ trans('modals.group') }}</label>
                                                <div class="col-lg-9">
                                                    <el-select :value="wish.group_id" :placeholder="trans('labels.group')" size="small" style="width: 100%;" @input="inputGroup">
                                                        <el-option
                                                                v-for="item in wish.groups"
                                                                :key="item.id"
                                                                :label="item.name"
                                                                :value="item.id">
                                                            <span style="float: left"><i :class="item.name"></i> {{ item.name }}</span>
                                                        </el-option>
                                                    </el-select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">&nbsp; {{ trans('modals.category') }}</label>
                                                <div class="col-lg-9">
                                                    <input type="text" class="form-control" :class="errors.has('category') ? 'is-invalid': ''" id='category' name='category' :placeholder="trans('modals.category')" disabled readonly :value="wish.category"/>
                                                    <div class="invalid-feedback">
                                                        <strong v-text="errors.get('category')"></strong>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">&nbsp; {{ trans('modals.catering') }}</label>
                                                <div class="col-lg-9">
                                                    <input type="text" class="form-control" :class="errors.has('catering') ? 'is-invalid': ''" id='catering' name='catering' :placeholder="trans('modals.catering')" disabled readonly  :value="wish.catering"/>
                                                    <div class="invalid-feedback">
                                                        <strong v-text="errors.get('catering')"></strong>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">&nbsp; {{ trans('modals.status') }} </label>
                                                <div class="col-lg-9">
                                                    <el-switch
                                                            @input="updateStatus"
                                                            :value="wish.status"
                                                            active-color="#13ce66"
                                                            inactive-color="#ff4949">
                                                    </el-switch>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">&nbsp; {{ trans('modals.duration') }} <span class="text-danger"> *</span></label>
                                                <div class="col-lg-9">
                                                    <input type="text" class="form-control" :class="errors.has('duration') ? 'is-invalid': ''" id='duration' name='duration' :placeholder="trans('modals.duration')" disabled readonly  :value="wish.duration"/>
                                                    <div class="invalid-feedback">
                                                        <strong v-text="errors.get('duration')"></strong>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">&nbsp; {{ trans('modals.description') }}</label>
                                                <div class="col-lg-9">
                                                    <textarea class="form-control" :class="errors.has('description') ? 'is-invalid': ''" rows="5" id='description' name='description' :placeholder="trans('modals.description')" disabled readonly  :value="wish.description"></textarea>
                                                    <div class="invalid-feedback">
                                                        <strong v-text="errors.get('description')"></strong>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label">&nbsp;{{ trans('modals.image') }} <span class="text-danger"> *</span></label>
                                                <div class="col-lg-9">
                                                    <input type="url" class="form-control" :class="errors.has('featured_image') ? 'is-invalid': ''" id='featured_image' name='featured_image' :placeholder="trans('modals.image')" disabled readonly :value="wish.featured_image"/>
                                                    <div class="invalid-feedback">
                                                        <strong v-text="errors.get('featured_image')"></strong>
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
                            </form>                        </div>
                    </div>

                    <div class="tab-pane fade" id="highlighted-justified-tab2" v-if="can_logs">
                        <div class="modal-body">
                            <vue-table :options="wish.logs"></vue-table>
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
    name: 'EditWishComponent',
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
        this.EditWish(parseInt(this.$route.params.id))
      }
    },
    computed: {
      ...Vuex.mapGetters({
        wish: 'wish',
        user: 'currentUser'
      }),
      can_logs () {
        return !this.deleted && this.hasPermissionTo('logs-wish')
      }
    },
    methods: {
      ...Vuex.mapActions({
        addWish: 'addWish'
      }),
      hasPermissionTo (permission) {
        return this.user.hasOwnProperty('permissions') && this.user.permissions[permission]
      },
      inputGroup (value) {
        this.$store.commit('updateWish', {name: 'group_id', value: value})
      },
      getWish (key, value) {
        return (this.wish.hasOwnProperty(key)) ? this.wish[key][value] : ''
      },
      updateWish (e) {
        if (e.target.value !== null) {
          this.$store.commit('updateWish', {name: e.target.name, value: e.target.value})
        }
      },
      updateWishAdults (value) {
        if (value !== null) {
          this.$store.commit('updateWish', {name: 'adults', value: value})
        }
      },
      updateWishKids (value) {
        if (value !== null) {
          this.$store.commit('updateWish', {name: 'kids', value: value})
        }
      },
      updateWishBudget (value) {
        if (value !== null) {
          this.$store.commit('updateWish', {name: 'budget', value: value})
        }
      },
      updateStatus (value) {
        this.$store.commit('updateWish', {name: 'status', value: value})
      },
      loadModal () {
        let id = parseInt(this.$route.params.id)
        $('#modal_large_wish').on('hidden.bs.modal', () => {
          this.$router.push({name: 'root'})
        })

        if (id === 0) {
          this.CreateWish()
        } else {
          this.EditWish(id)
        }
      },
      CreateWish () {
        this.$store.dispatch('block', {element: 'wishesComponent', load: true})
        this.$http.get(window.laroute.route('admin.wishes.create'))
          .then(this.onLoadWishSuccess)
          .catch(this.onFailed)
          .then(() => {
            this.$store.dispatch('block', {element: 'wishesComponent', load: false})
          })
      },
      EditWish (id) {
        this.$store.dispatch('block', {element: 'wishesComponent', load: true})
        this.$http.get(window.laroute.route('admin.wishes.edit', {id: id}))
          .then(this.onLoadWishSuccess)
          .catch(this.onFailed)
          .then(() => {
            this.$store.dispatch('block', {element: 'wishesComponent', load: false})
          })
      },
      onLoadWishSuccess (response) {
        if (response.data.hasOwnProperty('success') && response.data.success === true) {
          this.addWish(response.data.wish)
          if (!($('#modal_large_wish').data('bs.modal') || {}).isShown) {
            $('#modal_large_wish').modal('show')
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
        this.$store.dispatch('block', {element: 'wishesComponent', load: true})
        this.$http.put(window.laroute.route('admin.wishes.store'), this.wish)
          .then(this.onSubmitSuccess)
          .catch(this.onFailed)
          .then(() => {
            this.$store.dispatch('block', {element: 'wishesComponent', load: false})
          })
      },
      onSubmitUpdate (id) {
        this.$store.dispatch('block', {element: 'wishesComponent', load: true})
        this.$http.put(window.laroute.route('admin.wishes.update', {id: id}), this.wish)
          .then(this.onSubmitSuccess)
          .catch(this.onFailed)
          .then(() => {
            this.$store.dispatch('block', {element: 'wishesComponent', load: false})
          })
      },
      onSubmitSuccess (response) {
        if (response.data.hasOwnProperty('success') && response.data.success === true) {
          if (this.close) {
            $('#modal_large_wish').modal('hide')
            this.$router.push({name: 'root'})
          } else {
            this.$router.push({name: 'root.edit', params: {id: response.data.wish.id}})
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
