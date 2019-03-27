<template>
    <!-- Large modal -->
    <div id="modal_large_language" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <form action="#" @submit.prevent="onSubmit" @keydown="errors.clear($event.target.name)">
                <div class="modal-content">
                    <div class="modal-header bg-steel">
                        <h5 class="modal-title"><i class="icon-menu7 mr-2"></i> &nbsp;Modal with icons</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body">
                        <fieldset>
                            <legend class="font-weight-semibold text-uppercase font-size-sm">
                                <i class="icon-collaboration mr-2"></i>
                                Language details
                                <a class="float-right text-default" data-toggle="collapse" data-target="#demo1">
                                    <i class="icon-circle-down2"></i>
                                </a>
                            </legend>
                            <div class="collapse show" id="demo1">
                                <div class="form-group row" v-if="language.id !== 0">
                                    <label class="col-lg-3 col-form-label">&nbsp;{{ trans('modals.id') }}</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control disabled" disabled readonly id='id' name='id' :placeholder="trans('modals.id')" :value="language.id"/>
                                        <div class="invalid-feedback">
                                            <strong v-text="errors.get('id')"></strong>
                                        </div>
                                    </div>
                                </div>
                                <el-select v-model="languageId" :placeholder="trans('modals.language')" @input="updateLanguage" :class="errors.has('language_id') ? 'is-invalid': ''" name='language_id'>
                                    <el-option style="width: 100%;"
                                               v-for="item in missingLanguages"
                                               :key="item.id"
                                               :label="item.locale"
                                               :value="item.id">
                                    </el-option>
                                </el-select>
                                <div class="invalid-feedback">
                                    <strong v-text="errors.get('language_id')"></strong>
                                </div>
                            </div>

                        </fieldset>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-outline bg-teal-600 text-teal-600 border-teal-600 btn-sm" v-on:click="close = false"><i class="icon-checkmark-circle mr-1"></i>{{ trans('button.save') }}</button>
                        <button type="submit" class="btn btn-outline bg-teal-400 text-teal-400 border-teal-400 btn-sm" v-on:click="close = true"><i class="icon-checkmark-circle mr-1"></i>{{ trans('button.save_and_close') }}</button>
                        <button type="button" class="btn btn-outline-danger btn-sm" data-dismiss="modal"><i class="icon-cancel-circle2 mr-1"></i> {{ trans('button.close') }}</button>
                    </div>
                </div>
            </form>
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
    name: 'AddLanguageComponent',
    components: { VueTable, DateComponent },
    data () {
      return {
        // eslint-disable-next-line
        errors: new Errors(),
        close: false,
        languageId: null
      }
    },
    mounted () {
      this.loadModal()
    },
    watch: {
    },
    computed: {
      ...Vuex.mapGetters({
        language: 'language',
        user: 'currentUser',
        whitelabels: 'whitelabels',
        missingLanguages: 'missingLanguages'
      })
    },
    methods: {
      ...Vuex.mapActions({
        addLanguage: 'addLanguage'
      }),
      hasPermissionTo (permission) {
        return this.user.hasOwnProperty('permissions') && this.user.permissions[permission]
      },
      hasRole (permission) {
        return this.user.hasOwnProperty('roles') && this.user.roles[permission]
      },
      updateLanguage (e) {
        if (this.languageId) {
          this.$store.commit('updateLanguage', {name: 'language_id', value: this.languageId})
        }
      },
      loadModal () {
        let id = parseInt(this.$route.params.id)
        $('#modal_large_language').on('hidden.bs.modal', () => {
          this.$router.push({name: 'root'})
        })

        if (id === 0) {
          this.CreateLanguage()
        }
      },
      CreateLanguage () {
        this.$store.dispatch('block', {element: 'groupsComponent', load: true})
        this.$http.get(window.laroute.route('provider.languages.create'))
          .then(this.onLoadLanguageSuccess)
          .catch(this.onFailed)
          .then(() => {
            this.$store.dispatch('block', {element: 'groupsComponent', load: false})
          })
      },
      onLoadLanguageSuccess (response) {
        if (response.data.hasOwnProperty('success') && response.data.success === true) {
          this.addLanguage(response.data.language)
          if (!($('#modal_large_language').data('bs.modal') || {}).isShown) {
            $('#modal_large_language').modal('show')
          }
        } else {
          toastr.error(response.data.message)
        }
      },
      onSubmit (e) {
        let id = parseInt(this.$route.params.id)
        if (id === 0) {
          this.onSubmitStore()
        }
      },
      onSubmitStore () {
        this.$store.dispatch('block', {element: 'languagesComponent', load: true})
        this.$http.put(window.laroute.route('provider.languages.store'), this.language)
          .then(this.onSubmitSuccess)
          .catch(this.onFailed)
          .then(() => {
            this.$store.dispatch('block', {element: 'languagesComponent', load: false})
          })
      },
      onSubmitSuccess (response) {
        if (response.data.hasOwnProperty('success') && response.data.success === true) {
          if (this.close) {
            $('#modal_large_language').modal('hide')
            this.$router.push({name: 'root'})
          } else {
            this.$router.push({name: 'root.edit', params: {id: response.data.language.id}})
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
