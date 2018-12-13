<template>
    <div class="list-icons">
        <a href="javascript:;" class="btn btn-outline btn-sm bg-slate-400 text-slate-800 btn-icon ml-2" @click="doView('view-item', rowData, rowIndex)" data-popup="tooltip" :title="trans('labels.read_more')"><i class="icon-search4"></i></a>
        <a href="javascript:;" class="btn btn-outline btn-sm bg-teal text-teal-800 btn-icon ml-2" v-if="rowData.status" @click="doMigrate('migrate-item', rowData, rowIndex)" data-popup="tooltip" :title="trans('labels.migrate')"><i class="icon-database"></i></a>
        <a href="javascript:;" class="btn btn-outline btn-sm bg-teal text-teal-800 btn-icon ml-2" v-if="!rowData.status" @click="doInstall('edit-item', rowData, rowIndex)" data-popup="tooltip" :title="trans('labels.install')"><i class="icon-cogs"></i></a>
        <a href="javascript:;" class="btn btn-outline btn-sm bg-danger text-danger-800 btn-icon ml-2" v-if="rowData.status" @click="doUninstall('delete-item', rowData, rowIndex)" data-popup="tooltip" :title="trans('labels.install')"><i class="icon-trash"></i></a>
    </div>
</template>

<script>
  import Vuex from 'vuex'
  export default {
    name: 'Actions',
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
      can_edit () {
        return !this.deleted && this.hasPermissionTo('update-wish')
      },
      deleted: function () {
        return this.rowData.deleted_at !== null
      }
    },
    methods: {
      doMigrate (action, data, index) {
        this.$events.fire('migrate-set', action, data, index)
      },
      doInstall (action, data, index) {
        this.$events.fire('install-set', action, data, index)
      },
      doView (action, data, index) {
        this.$events.fire('view-set', action, data, index)
      },
      doUninstall (id) {
        this.$events.fire('uninstall-set', id)
      },
      hasPermissionTo (permission) {
        return this.user.hasOwnProperty('permissions') && this.user.permissions[permission]
      }
    }
  }
</script>

<style>
</style>
