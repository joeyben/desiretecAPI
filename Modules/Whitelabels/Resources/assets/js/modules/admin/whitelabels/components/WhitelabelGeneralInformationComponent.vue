<template>
    <!-- Large modal -->
    <div class="card-body">
        <form action="#">
            <fieldset>
                <legend class="font-weight-semibold text-uppercase font-size-sm">
                    <i class="icon-check mr-2"></i>
                    General Information
                    <a class="float-right text-default" data-toggle="collapse" data-target="#demo1">
                        <i class="icon-circle-down2"></i>
                    </a>
                </legend>
                <div class="collapse show" id="demo1">
                    <div class="form-group row" v-if="whitelabel.id !== 0">
                        <label class="col-lg-3 col-form-label">&nbsp;{{ trans('modals.id') }}</label>
                        <div class="col-lg-9">
                            <input type="text" class="form-control disabled" disabled readonly id='id' name='id' :placeholder="trans('modals.id')" :value="whitelabel.id"/>
                            <div class="invalid-feedback">
                                <strong v-text="errors.get('id')"></strong>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label">&nbsp;{{ trans('modals.name') }} <span class="text-danger"> *</span></label>
                        <div class="col-lg-9">
                            <input type="text" class="form-control" :class="errors.has('name') ? 'is-invalid': ''" id='name' name='name' :placeholder="trans('modals.name')" @input="updateWhitelabel"  :value="whitelabel.name"/>
                            <div class="invalid-feedback">
                                <strong v-text="errors.get('name')"></strong>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label">&nbsp;{{ trans('modals.display_name') }} <span class="text-danger"> *</span></label>
                        <div class="col-lg-9">
                            <input type="text" class="form-control" :class="errors.has('display_name') ? 'is-invalid': ''" id='display_name' name='display_name' :placeholder="trans('modals.display_name')" @input="updateWhitelabel"  :value="whitelabel.display_name"/>
                            <div class="invalid-feedback">
                                <strong v-text="errors.get('display_name')"></strong>
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
                        <label class="col-lg-3 col-form-label"> &nbsp; {{ trans('validation.attributes.backend.whitelabels.associated_distribution') }}</label>
                        <div class="col-lg-9">
                            <el-select :value="whitelabel.distribution_id" :placeholder="trans('labels.group')" size="small" style="width: 100%;" @input="inputDistribution">
                                <el-option
                                        v-for="item in whitelabel.distributions"
                                        :key="item.id"
                                        :label="item.name"
                                        :value="item.id">
                                    <span style="float: left"><i :class="item.name"></i> {{ item.name }}</span>
                                </el-option>
                            </el-select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label">&nbsp; {{ trans('modals.status') }} </label>
                        <div class="col-lg-9">
                            <el-switch
                                    @input="updateStatus"
                                    :value="whitelabel.status"
                                    active-color="#13ce66"
                                    inactive-color="#ff4949">
                            </el-switch>
                        </div>
                    </div>

                    <legend class="font-weight-semibold"><i class="icon-upload mr-2"></i> {{ trans('modals.upload_photo') }}</legend>
                    <div class="form-group">
                        <upload-attachments :data="{name: 'whitelabel'}" :fileList="whitelabel.fileList" :limit="1" listType="picture-card"></upload-attachments>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
    <!-- /large modal -->
</template>
<script>
  import Vuex from 'vuex'
  import { Errors } from '../../../../../../../../../resources/assets/js/utils/errors'
  import UploadAttachments from '../../../../../../../../../resources/assets/js/utils/UploadAttachments'

  export default {
    name: 'WhitelabelGeneralInformationComponent',
    components: { UploadAttachments },
    data () {
      return {
        // eslint-disable-next-line
        errors: new Errors(),
        tabs: [{title: 'Personal details', icon: 'ti-user', component: 'WhitelabelGeneralInformationComponent'}
        ]
      }
    },
    mounted () {
    },
    watch: {
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
      updateStatus (value) {
        this.$store.commit('updateWhitelabel', {name: 'status', value: value})
      },
      inputDistribution (value) {
        this.$store.commit('updateWhitelabel', {name: 'distribution_id', value: value})
      },
      updateWhitelabel (e) {
        if (e.target.value !== null) {
          this.$store.commit('updateWhitelabel', {name: e.target.name, value: e.target.value})
        }
      },
      beforeTabSwitch: function () {
        alert('This is called before switchind tabs')
        return true
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
