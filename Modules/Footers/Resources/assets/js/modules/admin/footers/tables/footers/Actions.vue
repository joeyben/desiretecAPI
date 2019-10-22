<template>
    <div class="list-icons">
        <router-link class="btn btn-outline btn-sm bg-teal text-teal-800 btn-icon ml-2" :to="{name: 'root.edit', params: { id: rowData.id }}"  v-if="can_edit" data-popup="tooltip" :title="trans('button.edit')"><i class="icon-pencil"></i></router-link>
        <a href="javascript:;" class="btn btn-outline btn-sm bg-danger text-danger-800 btn-icon ml-2" @click="doDelete(rowData.id)" v-if="can_delete" data-popup="tooltip" :title="trans('button.delete')"><i class="icon-cancel-circle2"></i></a>
        <a href="javascript:;" class="btn btn-outline btn-sm bg-info text-info-800 btn-icon ml-2" @click="doRestore(rowData.id)" v-if="can_restore" data-popup="tooltip" :title="trans('button.restore')"><i class="icon-reset"></i></a>
        <a href="javascript:;" class="btn btn-outline btn-sm bg-danger text-danger-800 btn-icon ml-2" @click="doDestroy(rowData.id)" v-if="can_force_delete" data-popup="tooltip" :title="trans('button.delete')"><i class="icon-trash-alt"></i></a>
    </div>
</template>

<script>
  import Vuex from 'vuex'
  export default {
    name: 'Actions',
    data () {
      return {
      }
    },
    props: {
      rowData: {
        type: Object,
        required: true
      },
      rowIndex: {
        type: Number
      }
    },
    computed: {
      ...Vuex.mapGetters({
        user: 'currentUser'
      }),
      editUrl () {
        return window.laroute.route('admin.access.role.edit', {role: this.rowData.id})
      },
      deleteUrl () {
        return window.laroute.route('admin.access.role.destroy', {role: this.rowData.id})
      },
      can_edit () {
        return !this.deleted && this.hasRole('Administrator')
      },
      can_restore () {
        return this.deleted && this.hasRole('Administrator')
      },
      can_force_delete () {
        return this.deleted && this.hasRole('Administrator')
      },
      can_delete () {
        return !this.deleted && this.hasRole('Administrator')
      },
      deleted: function () {
        return this.rowData.deleted_at !== null
      }
    },
    methods: {
      doView (action, data, index) {
        this.$events.fire('view-set', action, data, index)
      },
      doRestore (id) {
        this.$events.fire('restore-set', id)
      },
      doDelete (id) {
        this.$events.fire('delete-set', id)
      },
      doDestroy (id) {
        this.$events.fire('destroy-set', id)
      },
      hasPermissionTo (permission) {
        return this.user.hasOwnProperty('permissions') && this.user.permissions[permission]
      },
      hasRole (permission) {
        return this.user.hasOwnProperty('roles') && this.user.roles[permission]
      }
    }
  }
</script>

<style>
</style>
