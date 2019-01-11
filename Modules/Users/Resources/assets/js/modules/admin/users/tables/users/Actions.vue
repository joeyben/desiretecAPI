<template>
    <div class="list-icons">
        <a :href="editUrl" class="btn btn-outline btn-sm bg-teal text-teal-800 btn-icon ml-2" v-if="can_edit" data-popup="tooltip" :title="trans('button.edit')"><i class="icon-pencil7"></i></a>
        <a href="javascript:;" class="btn btn-outline btn-sm bg-danger text-danger-800 btn-icon ml-2" @click="doDelete(rowData.id)" v-if="can_delete" data-popup="tooltip" :title="trans('button.delete')"><i class="icon-cancel-circle2"></i></a>
        <a :href="loginAsUserUrl" class="btn btn-outline btn-sm bg-success text-success-800 btn-icon ml-2"  v-if="can_login" data-popup="tooltip" :title="trans('buttons.backend.access.users.login_as', {user: name})"><i class="icon-user-check"></i></a>
        <a :href="deactivateUserUrl" class="btn btn-outline btn-sm bg-slate text-slate-800 btn-icon ml-2"  v-if="can_deactivate_user" data-popup="tooltip" :title="trans('buttons.backend.access.users.deactivate')"><i class="icon-lock4"></i></a>
        <a :href="activateUserUrl" class="btn btn-outline btn-sm bg-primary text-primary btn-icon ml-2"  v-if="can_activate_user" data-popup="tooltip" :title="trans('buttons.backend.access.users.activate')"><i class="icon-unlocked"></i></a>
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
        return window.laroute.route('admin.access.user.edit', {user: this.rowData.id})
      },
      loginAsUserUrl () {
        return window.laroute.route('admin.access.user.edit', {user: this.rowData.id})
      },
      deactivateUserUrl () {
        return window.laroute.route('admin.access.user.mark', {user: this.rowData.id, status: 0})
      },
      activateUserUrl () {
        return window.laroute.route('admin.access.user.mark', {user: this.rowData.id, status: 1})
      },
      deleteUrl () {
        return window.laroute.route('admin.access.user.destroy', {user: this.rowData.id})
      },
      can_edit () {
        return !this.deleted && this.hasPermissionTo('edit-user')
      },
      can_restore () {
        return this.deleted && this.hasRole('Administrator')
      },
      can_force_delete () {
        return this.deleted && this.hasRole('Administrator')
      },
      can_delete () {
        return !this.deleted && this.hasPermissionTo('delete-user')
      },
      deleted: function () {
        return this.rowData.deleted_at !== null
      },
      can_deactivate_user: function () {
        return !this.deleted && this.hasPermissionTo('deactivate-user') && (this.rowData.status)
      },
      can_activate_user: function () {
        return !this.deleted && this.hasPermissionTo('activate-user') && (!this.rowData.status)
      },
      can_login: function () {
        let index = -1
        if (this.rowData.hasOwnProperty('roles')) {
          index = this.rowData.roles.findIndex((p) => p.name === 'Administrator')
        }
        return !this.deleted && this.hasPermissionTo('can-login-as-user') && (index === -1)
      },
      name: function () {
        return this.user.hasOwnProperty('full_name') ? this.user.full_name : ''
      }
    },
    methods: {
      doView (action, data, index) {
        this.$events.fire('view-set', action, data, index)
      },
      doDelete (id) {
        this.$events.fire('delete-set', id)
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
