<template>
    <div class="table-responsive">
        <el-upload
                class="upload-demo"
                multiple
                :action="url"
                name="attachment"
                :limit="limit"
                :on-exceed="handleExceed"
                :on-preview="handlePreview"
                :on-remove="handleRemove"
                :before-upload="beforeAvatarUpload"
                :before-remove="beforeRemove"
                :on-success="handleSuccess"
                :headers="headers"
                :file-list="fileList"
                :accept="accept"
                :data="data"
                :list-type="listType">
            <el-button size="small" type="primary">{{ trans('modals.click_to_upload') }}</el-button>
            <div slot="tip" class="el-upload__tip">{{ tip }}</div>
        </el-upload>
        <el-dialog :visible.sync="dialogVisible" size="tiny">
            <img width="100%" :src="dialogImageUrl" alt="">
        </el-dialog>
    </div>
</template>

<script>
    import Vuex from 'vuex'
    import { Errors } from './errors'
    export default {
      name: 'UploadAttachments',
      props: {
        data: Object,
        fileList: {
          default: function () { return [] },
          type: Array
        },
        limit: {
          type: Number,
          default: 20
        },
        accept: {
          type: String,
          default: 'image/*'
        },
        listType: {
          type: String,
          default: 'picture'
        },
        tip: {
          type: String,
          default: window.Lang.get('modals.upload_tip')
        }
      },
      data () {
        return {
          // eslint-disable-next-line
          errors: new Errors(),
          url: window.laroute.route('attachments.store'),
          deleteUrl: 'attachments.destroy',
          dialogImageUrl: '',
          dialogVisible: false,
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        }
      },
      components: { },
      computed: {
        ...Vuex.mapGetters({
        })
      },
      methods: {
        ...Vuex.mapActions({
        }),
        handleRemove (file, fileList) {
          if (file.hasOwnProperty('response')) {
            this.onDestroy(file.response.attachment.id)
          } else {
            this.onDestroy(file.uid)
          }
        },
        handlePreview (file) {
          this.dialogImageUrl = file.url
          this.dialogVisible = true
        },
        beforeRemove (file, fileList) {
          return this.$confirm(`Are you sure you want to delete ${file.name}`)
        },
        handleSuccess (response, file, fileList) {
          this.$events.fire('handle-success-file', response)
        },
        beforeAvatarUpload (file) {
          let isJPG = (file.type === 'image/jpeg' || file.type === 'image/png' || file.type === 'image/png' || file.type === 'image/svg')
          let isLt2M = file.size / 1024 / 1024 < 1

          if (!isJPG) {
            this.$message({
              message: 'Avatar picture must be JPG|png format!',
              showClose: true,
              type: 'error'
            })
          }
          if (!isLt2M) {
            this.$message({
              message: 'Avatar picture size can not exceed 1MB!',
              showClose: true,
              type: 'error'
            })
          }
          return isJPG && isLt2M
        },
        handleExceed (files, fileList) {
          this.$message({
            message: `The limit is ${this.limit}, you selected ${files.length} files this time, add up to ${files.length + fileList.length} totally`,
            showClose: true,
            type: 'warning'
          })
        },
        onDestroy (id) {
          this.$http.delete(window.laroute.route(this.deleteUrl, {id: id}))
            .then((response) => {
              if (response.data.hasOwnProperty('success') && response.data.success === true) {
                this.$events.fire('handle-remove-file', response)
              } else {
                this.$message({
                  message: response.data.message,
                  showClose: true,
                  type: 'error'
                })
              }
            })
            .catch(this.onFailed)
        },
        onFailed (error) {
          if (error.response !== undefined && error.response.hasOwnProperty('data')) {
            this.errors.record(error.response.data.errors)
            if ((error.response.data.hasOwnProperty('success') && error.response.data.success === false) || error.response.data.hasOwnProperty('message')) {
              this.$message({
                message: error.response.data.message,
                showClose: true,
                type: 'error'
              })
            } else {
              this.$message({
                message: this.errors.getErrors(this.errors.errors),
                showClose: true,
                type: 'error'
              })
            }
          } else if (error.hasOwnProperty('message')) {
            this.$message({
              message: error.message,
              showClose: true,
              type: 'error'
            })
          } else {
            this.$message({
              message: 'Service not answer, Please contact your Support',
              showClose: true,
              type: 'error'
            })
            console.log(error)
          }
        }
      }
    }
</script>
