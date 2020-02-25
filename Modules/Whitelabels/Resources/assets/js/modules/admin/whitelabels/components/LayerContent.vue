<template>
    <form action="#" @submit.prevent="onSubmit" @keydown="errors.clear($event.target.name)">

        <fieldset class="mb-3">
            <div class="form-group">
                <upload-attachments :data="{attachable_id: parseInt(layer.id), attachable_type: 'Modules\\Whitelabels\\Entities\\LayerWhitelabel', type: 'whitelabels', folder: 'layers'}" :fileList="layer.attachments" :tip="trans('modals.visual')" :limit="1" listType="picture-card"></upload-attachments>
            </div>


            <div class="form-group row mt-5">
                <label class="col-lg-3 col-form-label">&nbsp;{{ trans('modals.headline') }}</label>
                <div class="col-lg-9">
                    <input type="text" class="form-control" :class="errors.has('headline') ? 'is-invalid': ''" :id="name + 'headline'" :name="name + 'headline'" :placeholder="trans('modals.headline')"  v-model="headline"/>
                    <div class="invalid-feedback">
                        <strong v-text="errors.get('headline')"></strong>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-lg-3 col-form-label">&nbsp;{{ trans('modals.subheadline') }}</label>
                <div class="col-lg-9">
                    <textarea rows="5" cols="5" class="form-control" :class="errors.has('subheadline') ? 'is-invalid': ''" :id="name + 'subheadline'" :name="name + 'subheadline'" :placeholder="trans('modals.subheadline')"  v-model="subheadline"></textarea>
                    <div class="invalid-feedback">
                        <strong v-text="errors.get('subheadline')"></strong>
                    </div>
                </div>
            </div>

            <legend class="text-uppercase font-size-sm font-weight-bold">{{ trans('modals.message_success') }}</legend>

            <div class="form-group row">
                <label class="col-lg-3 col-form-label">&nbsp;{{ trans('modals.headline_success') }}</label>
                <div class="col-lg-9">
                    <input type="text" class="form-control" :class="errors.has('headline_success') ? 'is-invalid': ''" :id="name + 'headline_success'" :name="name + 'headline_success'" :placeholder="trans('modals.headline_success')" v-model="headline_success"/>
                    <div class="invalid-feedback">
                        <strong v-text="errors.get('headline_success')"></strong>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-lg-3 col-form-label">&nbsp;{{ trans('modals.subheadline_success') }}</label>
                <div class="col-lg-9">
                    <textarea rows="5" cols="5" class="form-control" :class="errors.has('subheadline_success') ? 'is-invalid': ''" :id="name + 'subheadline_success'" :name="name + 'subheadline_success'" :placeholder="trans('modals.subheadline_success')"  v-model="subheadline_success"></textarea>
                    <div class="invalid-feedback">
                        <strong v-text="errors.get('subheadline_success')"></strong>
                    </div>
                </div>
            </div>
        </fieldset>

        <div class="text-right">
            <button type="submit" class="btn btn-primary">
                {{ trans('button.save') }}
                <i class="icon-paperplane ml-2"></i>
            </button>
        </div>
    </form>
</template>

<script>
  import { Errors } from '../../../../../../../../../resources/assets/js/utils/errors'
  import UploadAttachments from '../../../../../../../../../resources/assets/js/utils/UploadAttachments'
  export default {
    name: 'LayerContent',
    components: { Errors, UploadAttachments },
    props: {
      layer: {
        type: Object,
        required: true
      }
    },
    data () {
      return {
        // eslint-disable-next-line
        errors: new Errors(),
        obj: {},
        id: null,
        name: '',
        headline: '',
        whitelabel_id: null,
        subheadline: '',
        headline_success: '',
        subheadline_success: '',
        attachments: []
      }
    },
    mounted () {
      this.initValues()
    },
    watch: {
      layer (val) {
        this.initValues()
      }
    },
    methods: {
      initValues() {
        if (Object.entries(this.layer).length !== 0) {
          let { id, name, headline, subheadline, headline_success, subheadline_success, whitelabel_id, attachments } = JSON.parse(JSON.stringify(this.layer))
          this.id = id
          this.name = name
          this.whitelabel_id = whitelabel_id
          this.headline = headline
          this.subheadline = subheadline
          this.headline_success = headline_success
          this.subheadline_success = subheadline_success
          this.attachments = attachments
        }
      },
      onSubmit () {
        this.$store.dispatch('block', {element: 'contentComponent', load: true})
        this.$http.put(window.laroute.route('admin.whitelabels.content.update'), {id: this.id, name: this.name, whitelabel_id: this.whitelabel_id, headline: this.headline, subheadline: this.subheadline, headline_success: this.headline_success, subheadline_success: this.subheadline_success})
          .then(this.onSubmitSuccess)
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
          this.errors.drop()
        } else {
          this.$message({
            message: response.data.message,
            showClose: true,
            type: 'error'
          })
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
