<template>
    <!-- Inner container -->
    <div>
        <!-- Tree with checkbox -->
        <div class="card">
            <div class="card-header bg-light header-elements-inline">
                <div class="header-elements">
                    <router-link class="btn btn-outline btn-sm bg-slate text-slate-800 btn-icon rounded-round ml-2" :to="{name: 'root.create'}"  v-if="can_create" data-popup="tooltip" :title="trans('modals.create')"><i class="icon-plus2"></i></router-link>
                </div>
            </div>

            <div class="card-body">
                <div class="form-group">
                    <el-input placeholder="Filter keyword" v-model="filterText"></el-input>
                </div>
                <div class="card card-body border-left-danger border-left-2">
                    <el-tree
                            v-if="show"
                            :load="loadNode"
                            :props="defaultProps"
                            lazy
                            class="filter-tree"
                            node-key="id"
                            :filter-node-method="filterNode"
                            ref="tree"
                            accordion
                            show-checkbox
                            @check-change="handleCheckChange"
                            :expand-on-click-node="false">
                            <span class="custom-tree-node" slot-scope="{ node, data }">
                            <span>{{ node.label }}</span>
                            <span>
                              <a href="javascript:;" @click="() => edit(data)"  class="btn btn-outline btn-sm bg-teal text-teal-800 btn-icon rounded-round ml-2" v-if="can_edit">
                                   <i class="icon-pencil6"></i>
                              </a>
                              <a href="javascript:;" @click="() => append(data)"  class="btn btn-outline btn-sm bg-info text-info-800 btn-icon rounded-round ml-2" v-if="can_create">
                                   <i class="icon-plus-circle2"></i>
                              </a>
                              <a href="javascript:;"  @click="() => remove(node, data)" class="btn btn-outline btn-sm bg-danger text-danger-800 btn-icon rounded-round ml-2" v-if="can_delete">
                                   <i class="icon-cancel-circle2"></i>
                              </a>
                            </span>
                            </span>
                    </el-tree>
                </div>
            </div>
            <router-view></router-view>
        </div>
    </div>
    <!-- /inner container -->
</template>
<style>
    .custom-tree-node {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-size: 14px;
        padding-right: 8px;
    }
</style>
<script>
  import Vuex from 'vuex'
  import { Errors } from '../../../../../../../../../resources/assets/js/utils/errors'
  export default {
    name: 'CategoriesComponent',
    components: { },
    data () {
      return {
        // eslint-disable-next-line
        errors: new Errors(),
        show: true,
        filterText: '',
        defaultProps: {
          children: 'zones',
          label: 'name'
        }
      }
    },
    mounted () {
      this.loadUser()
    },
    watch: {
      filterText (val) {
        this.$refs.tree.filter(val)
      }
    },
    computed: {
      ...Vuex.mapGetters({
        user: 'currentUser'
      }),
      can_edit () {
        return this.hasPermissionTo('update-category')
      },
      can_create () {
        return this.hasPermissionTo('create-category')
      },
      can_delete () {
        return this.hasPermissionTo('delete-category')
      }
    },
    methods: {
      ...Vuex.mapActions({
        loadUser: 'loadLoggedUser'
      }),
      hasPermissionTo (permission) {
        return this.user.hasOwnProperty('permissions') && this.user.permissions.hasOwnProperty(permission) && this.user.permissions[permission]
      },
      loadNode (node, resolve) {
        if (node.level === 0) {
          this.$store.dispatch('block', {element: 'categoriesComponent', load: true})
          return window.axios.get(window.laroute.route('admin.categories.view')).then(
            (response) => resolve(response.data.categories)
          )
            .catch(this.onFailed)
            .then(() => {
              this.$store.dispatch('block', {element: 'categoriesComponent', load: false})
            })
        }

        if (node.level > 0) {
          return this.$http.get(window.laroute.route('admin.categories.children', {id: node.data.id})).then(
            (response) => resolve(response.data.children)
          )
            .catch(this.onFailed)
            .then(() => {
            })
        }

        if (node.level > 1) return resolve([])

        setTimeout(() => {
          const data = [{
            name: 'leaf',
            leaf: true
          }, {
            name: 'zone'
          }]

          resolve(data)
        }, 500)
      },
      reload () {
        this.show = false
        this.$nextTick(() => {
          this.show = true
        })
      },
      handleCheckChange (data, checked, indeterminate) {
        console.log(data, checked, indeterminate)
      },
      filterNode (value, data) {
        if (!value) return true
        return data.name.indexOf(value) !== -1
      },
      edit (data) {
        this.$router.push({name: 'root.edit', params: {id: data.id}})
      },
      append (data) {
        this.$router.push({name: 'root.append', params: {id: data.id}})
      },
      onDeleteSuccess (response) {
        if (response.data.hasOwnProperty('success') && response.data.success === true) {
          this.$message({
            message: response.data.message,
            showClose: true,
            type: 'success'
          })
          this.reload()
        } else {
          this.$notify.error({ title: 'Error', message: response.data.message })
        }
      },
      remove (node, data) {
        this.$confirm(this.trans('messages.destroy'), 'Warning', {
          confirmButtonText: this.trans('labels.ok'),
          cancelButtonText: this.trans('labels.cancel'),
          type: 'warning'
        }).then(() => {
          this.onDelete(data.id)
        }).catch(() => {
          this.$message({
            type: 'info',
            message: this.trans('messages.delete_canceled')
          })
        })
      },
      onDelete (id) {
        this.$store.dispatch('block', {element: 'categoriesComponent', load: true})
        this.$http.delete(window.laroute.route('admin.categories.destroy', {id: id}))
          .then(this.onDeleteSuccess)
          .catch(this.onFailed)
          .then(() => {
            this.$store.dispatch('block', {element: 'categoriesComponent', load: false})
          })
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
