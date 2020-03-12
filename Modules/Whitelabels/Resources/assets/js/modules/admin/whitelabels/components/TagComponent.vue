<template>
    <div class="form-group row">
        <label class="col-lg-3 col-form-label">&nbsp;{{ trans('modals.hosts') }} <span class="text-danger"> *</span></label>
        <div class="col-lg-9">

            <el-tag
                    :key="tag"
                    v-for="tag in dynamicTags"
                    closable
                    :disable-transitions="false"
                    @close="handleClose(tag)">
                {{ 'https://' + tag}}
            </el-tag>
            <el-input
                    class="input-new-tag"
                    v-if="inputVisible"
                    v-model="inputValue"
                    ref="saveTagInput"
                    size="mini"
                    @keyup.enter.native="handleInputConfirm"
                    @blur="handleInputConfirm"
            >
            <template slot="prepend">https://</template>
            </el-input>
            <el-button v-else class="button-new-tag" size="small" @click="showInput">+ Domain hinzufügen</el-button>
        </div>
    </div>
</template>

<script>
  import { Errors } from '../../../../../../../../../resources/assets/js/utils/errors'
  export default {
    data () {
      return {
        // eslint-disable-next-line
        errors: new Errors(),
        dynamicTags: [],
        inputVisible: false,
        inputValue: '',
        tag: ''
      }
    },
    props: {
      hostsList: {
        default: function () {
          return []
        },
        type: Array
      },
      whitelebelId: {
        default: function () {
          return null
        },
        type: Number
      }
    },
    name: 'TagComponent',
    mounted () {
      this.initValues()
    },
    watch: {
      hostsList () {
        this.initValues()
      }
    },
    methods: {
      initValues () {
        if (Object.entries(this.hostsList).length !== 0) {
          this.dynamicTags = JSON.parse(JSON.stringify(this.hostsList))
        }
      },
      handleClose (tag) {
        this.tag = tag
        this.$store.dispatch('block', {element: 'whitelabelsProviderComponent', load: true})
        this.$http.delete(window.laroute.route('provider.hosts.destroy', {host: tag}), {host: tag})
          .then(this.onDeleteSuccess)
          .catch(this.onFailed)
          .then(() => {
            this.$store.dispatch('block', {element: 'whitelabelsProviderComponent', load: false})
          })
      },

      showInput () {
        this.inputVisible = true;
        this.$nextTick(_ => {
          this.$refs.saveTagInput.$refs.input.focus()
        })
      },

      handleInputConfirm () {
        let inputValue = this.inputValue
        if (inputValue) {
          this.$store.dispatch('block', {element: 'whitelabelsProviderComponent', load: true})
          this.$http.post(window.laroute.route('provider.hosts.store'), {host: 'https://' + inputValue, whitelebelId: this.whitelebelId})
            .then(this.onSubmitSuccess)
            .catch(this.onFailed)
            .then(() => {
              this.$store.dispatch('block', {element: 'whitelabelsProviderComponent', load: false})
            })
        }
      },
      onDeleteSuccess (response) {
        if (response.data.hasOwnProperty('success') && response.data.success === true) {
          this.$message({
            message: response.data.message,
            showClose: true,
            type: 'success'
          })
          this.dynamicTags.splice(this.dynamicTags.indexOf(this.tag), 1)
        } else {
          this.$message({
            message: response.data.message,
            showClose: true,
            type: 'error'
          })
        }
      },
      onSubmitSuccess (response) {
        if (response.data.hasOwnProperty('success') && response.data.success === true) {
          this.$message({
            message: response.data.message,
            showClose: true,
            type: 'success'
          })
          this.dynamicTags.push(this.inputValue)
          this.inputVisible = false
          this.inputValue = ''
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
    .el-tag + .el-tag {
        margin-left: 10px;
    }
    .button-new-tag {
        margin-left: 10px;
        height: 32px;
        line-height: 30px;
        padding-top: 0;
        padding-bottom: 0;
    }
    .input-new-tag {
        width: 190px;
        margin-left: 10px;
        vertical-align: bottom;
    }
</style>
