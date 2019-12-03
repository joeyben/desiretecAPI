<template>
    <!-- Large modal -->
    <div id="modal_large_languagelines" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="icon-menu7 mr-2"></i> &nbsp;</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form action="#" @submit.prevent="onSubmit" @keydown="errors.clear($event.target.name)">
                        <div class="modal-body">
                            <fieldset>
                                <legend class="font-weight-semibold text-uppercase font-size-sm">
                                    <i class="icon-copy4 mr-2"></i>
                                    {{ trans('button.replace') }}
                                </legend>
                                <div class="collapse show">
                                    <div class="form-group">
                                        <el-transfer style="width: 100%;margin-left: 5%;"
                                                     @input="inputWhitelabels"
                                                     filterable
                                                     :titles="['Source', 'Target']"
                                                     :value="selected"
                                                     :data="generateWhitelabels">
                                        </el-transfer>
                                        <div class="help-block text-danger" v-if="errors.has('whitelabels')">
                                            <strong v-text="errors.get('whitelabels')"></strong>
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
                    </form>
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
  export default {
    name: 'ReplaceLanguageLinesComponent',
    components: { VueTable },
    data () {
      return {
        // eslint-disable-next-line
        errors: new Errors(),
        selected: [],
        close: false
      }
    },
    mounted () {
      this.loadModal()
    },
    watch: {
    },
    computed: {
      ...Vuex.mapGetters({
        whitelabels: 'whitelabels',
        user: 'currentUser',
        checked: 'checked'
      }),
      generateWhitelabels () {
        let data = []
        if (this.whitelabels.length > 0) {
          this.whitelabels.forEach((whitelabel, index) => {
            data.push({
              label: whitelabel['name'],
              key: whitelabel['id'],
              disabled: false
            })
          })
        }

        return data
      },
      can_copy () {
        return this.hasRole('Administrator')
      }
    },
    methods: {
      ...Vuex.mapActions({
      }),
      inputWhitelabels (value) {
        this.errors.clear('whitelabels')
        this.selected = value
      },
      hasPermissionTo (permission) {
        return this.user.hasOwnProperty('permissions') && this.user.permissions[permission]
      },
      hasRole (permission) {
        return this.user.hasOwnProperty('roles') && this.user.roles[permission]
      },
      loadModal () {
        $('#modal_large_languagelines').on('hidden.bs.modal', () => {
          this.$router.push({name: 'root'})
        })
        if (!($('#modal_large_languagelines').data('bs.modal') || {}).isShown) {
          $('#modal_large_languagelines').modal('show')
        }
      },
      onSubmit (e) {
        this.$store.dispatch('block', {element: 'languageLinesComponent', load: true})
        this.$http.put(window.laroute.route('provider.language-lines.replace'), {whitelabels: this.selected, checked: this.checked})
          .then(this.onSubmitSuccess)
          .catch(this.onFailed)
          .then(() => {
            this.$store.dispatch('block', {element: 'languageLinesComponent', load: false})
          })
      },
      onSubmitSuccess (response) {
        if (response.data.hasOwnProperty('success') && response.data.success === true) {
          if (this.close) {
            $('#modal_large_languagelines').modal('hide')
            this.$router.push({name: 'root'})
          } else {
            this.$router.push({name: 'root.export'})
          }

          this.$message({
            message: response.data.message,
            showClose: true,
            type: 'success'
          })
          this.$parent.$children[0].refresh()
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
