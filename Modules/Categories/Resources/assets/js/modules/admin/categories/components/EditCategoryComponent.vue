<template>
    <!-- Large modal -->
    <div id="modal_large_category" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <form action="#" @submit.prevent="onSubmit" @keydown="errors.clear($event.target.name)">
                <div class="modal-content">
                    <div class="modal-header bg-steel">
                        <h5 class="modal-title"><i class="icon-menu7 mr-2"></i> &nbsp;Modal with icons</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <fieldset>
                            <legend class="font-weight-semibold"><i class="icon-graduation mr-2"></i> Enter your information</legend>
                            <div class="collapse show" id="demo1">
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">&nbsp; {{ trans('modals.id') }} <span class="text-danger">&nbsp;* </span></label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" disabled readonly :class="errors.has('id') ? 'is-invalid': ''" id="id" name="id" :placeholder="trans('modals.id')" :value="category.id"/>
                                        <div class="invalid-feedback">
                                            <strong v-text="errors.get('id')"></strong>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">&nbsp; {{ trans('modals.name') }} <span class="text-danger">&nbsp;* </span></label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" :class="errors.has('name') ? 'is-invalid': ''" id="name" name="name" :placeholder="trans('modals.name')" @input="updateCategory"  :value="category.name"/>
                                        <div class="invalid-feedback">
                                            <strong v-text="errors.get('name')"></strong>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">&nbsp; {{ trans('modals.value') }} <span class="text-danger">&nbsp;* </span></label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" :class="errors.has('value') ? 'is-invalid': ''" id="value" name="value" :placeholder="trans('modals.value')" @input="updateCategory"  :value="category.value"/>
                                        <div class="invalid-feedback">
                                            <strong v-text="errors.get('value')"></strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <div class="modal-footer">
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
    export default {
      name: 'EditCategoryComponent',
      components: { },
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
          this.loadModal()
        }
      },
      computed: {
        ...Vuex.mapGetters({
          category: 'category'
        })
      },
      updated () {
      },
      methods: {
        ...Vuex.mapActions({
          addCategory: 'addCategory'
        }),
        getCategory (key, value) {
          return (this.category.hasOwnProperty(key)) ? this.category[key][value] : ''
        },
        updateCategory (e) {
          if (e.target.value !== null) {
            this.$store.commit('updateCategory', {name: e.target.name, value: e.target.value})
          }
        },
        loadModal () {
          let id = parseInt(this.$route.params.id)
          $('#modal_large_category').on('hidden.bs.modal', () => {
            this.$router.push({name: 'root'})
          })

          if (this.$route.name === 'root.create') {
            this.loadCategory(window.laroute.route('admin.categories.create'))
          } else if (this.$route.name === 'root.edit') {
            this.loadCategory(window.laroute.route('admin.categories.edit', {id: id}))
          } else if (this.$route.name === 'root.append') {
            this.loadCategory(window.laroute.route('admin.categories.append', {id: id}))
          }
        },
        loadCategory (url) {
          this.$store.dispatch('block', {element: 'categoriesComponent', load: true})
          this.$http.get(url)
            .then(this.onLoadCategorySuccess)
            .catch(this.onFailed)
            .then(() => {
              this.$store.dispatch('block', {element: 'categoriesComponent', load: false})
            })
        },
        onSubmit () {
          if (this.$route.name === 'root.create') {
            this.onCreate()
          } else if (this.$route.name === 'root.edit') {
            this.onUpdate()
          } else if (this.$route.name === 'root.append') {
            this.onCreate()
          }
        },
        onCreate () {
          this.$store.dispatch('block', {element: 'categoriesComponent', load: true})
          this.$http.put(window.laroute.route('admin.categories.store'), this.category)
            .then(this.onSubmitSuccess)
            .catch(this.onFailed)
            .then(() => {
              this.$store.dispatch('block', {element: 'categoriesComponent', load: false})
            })
        },
        onUpdate () {
          this.$store.dispatch('block', {element: 'categoriesComponent', load: true})
          this.$http.put(window.laroute.route('admin.categories.update', {id: parseInt(this.$route.params.id)}), this.category)
            .then(this.onSubmitSuccess)
            .catch(this.onFailed)
            .then(() => {
              this.$store.dispatch('block', {element: 'categoriesComponent', load: false})
            })
        },
        onSubmitSuccess (response) {
          if (response.data.hasOwnProperty('success') && response.data.success === true) {
            if (this.close) {
              $('#modal_large_category').modal('hide')
              this.$router.push({name: 'root'})
            } else if (this.category.id === 0) {
              this.$router.push({name: 'root.edit', params: {id: response.data.category.id}})
            }
            this.$message({
              message: response.data.message,
              showClose: true,
              type: 'success'
            })
            this.$parent.reload()
          } else {
            this.$notify.error({ title: 'Error', message: response.data.message })
          }
        },
        onLoadCategorySuccess (response) {
          if (response.data.hasOwnProperty('success') && response.data.success === true) {
            this.addCategory(response.data.category)
            $('#modal_large_category').modal('show')
          } else {
            this.$notify.error({ title: 'Error', message: response.data.message })
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
