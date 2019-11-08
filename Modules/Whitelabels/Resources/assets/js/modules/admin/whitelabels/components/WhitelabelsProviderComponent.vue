<template>
    <!-- Form inputs -->
    <div class="card">
        <div class="card-body">
            <form action="#" @submit.prevent="onSubmit" @keydown="errors.clear($event.target.name)">
                <fieldset class="mb-3">
                    <legend class="font-weight-semibold"><i class="icon-pencil mr-2"></i></legend>
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
                        <label class="col-lg-3 col-form-label">&nbsp;{{ trans('modals.domain') }} <span class="text-danger"> *</span></label>
                        <div class="col-lg-9">
                            <div class="input-group">
                                <input type="text" class="form-control" :class="errors.has('sub_domain') ? 'is-invalid': ''" id='sub_domain' name='sub_domain' :placeholder="trans('modals.domain')" @input="updateWhitelabel"  :value="whitelabel.sub_domain"/>
                                <span class="input-group-append">
                                    <span class="input-group-text">{{ whitelabel.main_domain }}</span>
                                </span>
                            </div>
                            <div class="invalid-feedback">
                                <strong v-text="errors.get('sub_domain')"></strong>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label">&nbsp;{{ trans('modals.primary_color') }} <span class="text-danger"> *</span></label>
                        <div class="col-lg-9">
                            <el-color-picker :value="whitelabel.color" @input="updateWhitelabelColor"></el-color-picker>
                            <div class="invalid-feedback">
                                <strong v-text="errors.get('color')"></strong>
                            </div>
                        </div>
                    </div>
                    <legend class="font-weight-semibold"><i class="icon-upload mr-2"></i> {{ trans('modals.whitelabels_image') }}</legend>
                    <div class="form-group">
                        <upload-attachments :data="{attachable_id: parseInt(whitelabel.id), attachable_type: 'Modules\\Whitelabels\\Entities\\Whitelabel', type: 'whitelabels', folder: 'background'}" :fileList="whitelabel.background" :tip="trans('messages.background')" :limit="1" listType="picture-card"></upload-attachments>
                        <div class="help-block text-danger" v-if="errors.has('background')">
                            <strong v-text="errors.get('background')"></strong>
                        </div>
                    </div>
                    <legend class="font-weight-semibold"><i class="icon-upload mr-2"></i> {{ trans('Logo') }} </legend>
                    <div class="form-group">
                        <upload-attachments :data="{attachable_id: parseInt(whitelabel.id), attachable_type: 'Modules\\Whitelabels\\Entities\\Whitelabel', type: 'whitelabels', folder: 'logo'}" :fileList="whitelabel.logo" :limit="1" :tip="trans('messages.logo')" listType="picture-card"></upload-attachments>
                        <div class="help-block text-danger" v-if="errors.has('logo')">
                            <strong v-text="errors.get('logo')"></strong>
                        </div>
                    </div>
                    <legend class="font-weight-semibold"><i class="icon-upload mr-2"></i> {{ trans('Favicon') }} </legend>
                    <div class="form-group">
                        <upload-attachments :data="{attachable_id: parseInt(whitelabel.id), attachable_type: 'Modules\\Whitelabels\\Entities\\Whitelabel', type: 'whitelabels', folder: 'favicon'}" :fileList="whitelabel.favicon" :limit="1" :tip="trans('messages.favicon')" listType="picture-card"></upload-attachments>
                        <div class="help-block text-danger" v-if="errors.has('favicon')">
                            <strong v-text="errors.get('favicon')"></strong>
                        </div>
                    </div>
                </fieldset>

                <div class="text-right">
                    <button type="submit" class="btn btn-primary">{{ trans('button.save') }}</button>
                </div>
            </form>
        </div>
    </div>
    <!-- /form inputs -->
</template>

<script>
  import Vuex from 'vuex'
  import { Errors } from '../../../../../../../../../resources/assets/js/utils/errors'
  import VueTable from '../../../../../../../../../resources/assets/js/utils/Table.vue'
  import UploadAttachments from '../../../../../../../../../resources/assets/js/utils/UploadAttachments'

  export default {
    name: 'WhitelabelsProviderComponent',
    components: { VueTable, UploadAttachments },
    data () {
      return {
        // eslint-disable-next-line
        errors: new Errors(),
        close: false
      }
    },
    mounted () {
      this.loadCurrentWhitelabel()
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
        loadCurrentWhitelabel: 'loadCurrentWhitelabel'
      }),
      updateWhitelabel (e) {
        if (e.target.value !== null) {
          this.$store.commit('updateWhitelabel', {name: e.target.name, value: e.target.value})
        }
      },
      updateWhitelabelColor (value) {
        this.$store.commit('updateWhitelabel', {name: 'color', value: value})
      },
      onSubmit () {
        this.$store.dispatch('block', {element: 'whitelabelsProviderComponent', load: true})
        this.$http.put(window.laroute.route('provider.whitelabels.save', {id: this.whitelabel.id}), this.whitelabel)
          .then(this.onSubmitSuccess)
          .catch(this.onFailed)
          .then(() => {
            this.$store.dispatch('block', {element: 'whitelabelsProviderComponent', load: false})
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

<style scoped>

</style>
