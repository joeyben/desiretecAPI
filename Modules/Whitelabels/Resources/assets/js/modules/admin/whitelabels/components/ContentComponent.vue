
<template>
    <div>
        <filter-bar :defaultWhitelabel="whitelabel.id" v-if="whitelabel.id"></filter-bar>
        <!-- Form inputs -->
        <div class="card">
            <div class="card-body">

                <legend class="text-uppercase font-size-sm font-weight-bold">
                    <i class="icon-pencil ml-2"></i>
                </legend>

                <ul class="nav nav-tabs nav-tabs-highlight">
                    <li class="nav-item" v-for="(layer, index) in whitelabel.layers"  v-if="whitelabel.layers.length > 0">
                        <a :href="'#' + layer.name " class="nav-link" v-bind:class="{'active': index === 0}" data-toggle="tab">
                            {{ layer.name }}
                        </a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane fade" :data-tabnr="layer.id" v-for="(layer, index) in whitelabel.layers" v-bind:class="{'active show': index === 0}" :id="layer.name" >
                        <form action="#" @submit.prevent="onSubmit" @keydown="errors.clear($event.target.name)">

                            <input type="hidden" :name="'layer_id_'+layer.id" :id="'layer_id_'+layer.id" :value="layer.id">
                            <fieldset class="mb-3">
                                <div class="form-group">
                                    <upload-attachments :data="{attachable_id: parseInt(whitelabel.id), attachable_type: 'Modules\\Whitelabels\\Entities\\Whitelabel', type: 'whitelabels', folder: 'visual'}" :fileList="whitelabel.visual" :tip="trans('modals.visual')" :limit="1" listType="picture-card"></upload-attachments>
                                    <div class="help-block text-danger" v-if="errors.has('visual')">
                                        <strong v-text="errors.get('visual')"></strong>
                                    </div>
                                </div>

                                <div class="form-group row mt-5">
                                    <label class="col-lg-3 col-form-label">&nbsp;{{ trans('modals.headline') }}</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" :class="errors.has('headline') ? 'is-invalid': ''" id='headline' name='headline' :placeholder="trans('modals.headline')"  @input="updateWhitelabel" :value="layer.pivot.headline"/>
                                        <div class="invalid-feedback">
                                            <strong v-text="errors.get('headline')"></strong>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">&nbsp;{{ trans('modals.subheadline') }}</label>
                                    <div class="col-lg-9">
                                        <textarea rows="5" cols="5" class="form-control" :class="errors.has('subheadline') ? 'is-invalid': ''" id='subheadline' name='subheadline' :placeholder="trans('modals.subheadline')"  @input="updateWhitelabel" :value="layer.pivot.subheadline"></textarea>
                                        <div class="invalid-feedback">
                                            <strong v-text="errors.get('subheadline')"></strong>
                                        </div>
                                    </div>
                                </div>

                                <legend class="text-uppercase font-size-sm font-weight-bold">{{ trans('modals.message_success') }}</legend>

                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">&nbsp;{{ trans('modals.headline_success') }}</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" :class="errors.has('headline_success') ? 'is-invalid': ''" id='headline_success' name='headline_success' :placeholder="trans('modals.headline_success')" @input="updateWhitelabel"  :value="layer.pivot.headline_success"/>
                                        <div class="invalid-feedback">
                                            <strong v-text="errors.get('headline_success')"></strong>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">&nbsp;{{ trans('modals.subheadline_success') }}</label>
                                    <div class="col-lg-9">
                                        <textarea rows="5" cols="5" class="form-control" :class="errors.has('subheadline_success') ? 'is-invalid': ''" id='subheadline_success' name='subheadline_success' :placeholder="trans('modals.subheadline_success')" @input="updateWhitelabel"  :value="layer.pivot.subheadline_success"></textarea>
                                        <div class="invalid-feedback">
                                            <strong v-text="errors.get('subheadline_success')"></strong>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
-
                            <div class="text-right">
                                <button type="submit" class="btn btn-primary">
                                    {{ trans('button.save') }}
                                    <i class="icon-paperplane ml-2"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /form inputs -->
    </div>
</template>

<script>
  import Vuex from 'vuex'
  import { Errors } from '../../../../../../../../../resources/assets/js/utils/errors'
  import UploadAttachments from '../../../../../../../../../resources/assets/js/utils/UploadAttachments'
  import FilterBar from './FilterBar'
  export default {
    name: 'ContentComponent',
    components: { FilterBar, UploadAttachments },
    data () {
      return {
        // eslint-disable-next-line
        errors: new Errors(),
        contents: window.contents,
        radio1: null,
        dialogFormVisible: false,
        form: {
          id: ''
        }
      }
    },
    computed: {
      ...Vuex.mapGetters({
        whitelabel: 'whitelabel',
        whitelabels: 'whitelabels',
        user: 'currentUser'
      })
    },
    mounted () {
      this.loadUser()
      this.loadWhitelabels()
      this.loadCurrentWhitelabel()
      this.$events.$on('whitelabel-set', (id) => this.doWhitelabel(id))
    },
    methods: {
      ...Vuex.mapActions({
        loadUser: 'loadLoggedUser',
        loadWhitelabel: 'loadWhitelabel',
        loadWhitelabels: 'loadWhitelabels',
        loadCurrentWhitelabel: 'loadCurrentWhitelabel'
      }),
      updateWhitelabel (e) {
        if (e.target.value !== null) {
          var tabnr = parseInt($('.tab-content .active').data('tabnr') - 1)
          this.$store.commit('updateWhitelabel', {name: e.target.name, value: e.target.value, tabnr: tabnr})
        }
      },
      doWhitelabel (id) {
        this.loadWhitelabel(id)
      },
      doSeleted (value) {
        this.$store.commit('updateWhitelabel', {name: 'content', value: value})
        if (this.hasRole('Administrator')) {
          this.dialogFormVisible = true
        } else {
          this.onSubmit()
        }
      },
      onCreate () {
        this.dialogFormVisible = false
        this.onSubmit()
      },
      onSubmit () {
        this.$store.dispatch('block', {element: 'contentComponent', load: true})
        this.$http.put(window.laroute.route('admin.whitelabels.content.update'), this.whitelabel)
          .then(this.onSubmitStore)
          .catch(this.onFailed)
          .then(() => {
            this.$store.dispatch('block', {element: 'contentComponent', load: false})
          })
      },
      onSubmitSuccess (response) {
        if (response.data.hasOwnProperty('success') && response.data.success === true) {
          this.$message({
            message: response.data.message,
            showClose: true,
            type: 'success'
          })
        } else {
          this.$message({
            message: response.data.message,
            showClose: true,
            type: 'error'
          })
        }
      },
      hasRole (role) {
        return this.user.hasOwnProperty('roles') && this.user.roles[role]
      },
      hasPermissionTo (permission) {
        return this.user.hasOwnProperty('permissions') && this.user.permissions[permission]
      }
    }
  }
</script>

<style scoped>
    .time {
        font-size: 13px;
        color: #999;
    }

    .bottom {
        margin-top: 13px;
        line-height: 12px;
    }

    .button {
        padding: 0;
        float: right;
    }

    .image {
        width: 100%;
        display: block;
    }

    .clearfix:before,
    .clearfix:after {
        display: table;
        content: "";
    }

    .clearfix:after {
        clear: both
    }
</style>
