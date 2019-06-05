<template>
    <div class="list-icons">
        <a :href="url" class="btn btn-outline btn-sm bg-slate-400 text-slate-800 btn-icon ml-2"  data-popup="tooltip" :title="trans('labels.download')"><i class="icon-download"></i></a>
        <a href="javascript:;" class="btn btn-outline btn-sm bg-danger text-danger-800 btn-icon ml-2" @click="doDelete('delete-item', rowData.file_name, rowIndex)" v-if="can_delete" data-popup="tooltip" :title="trans('labels.delete')"><i class="icon-trash-alt"></i></a>
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
      url () {
        return window.laroute.route('admin.backups.download', {file: this.rowData.file_name})
      },
      can_delete () {
        return this.hasRole('Administrator')
      }
    },
    methods: {
      doDelete (action, data, index) {
        this.$events.fire('delete-set', action, data, index)
      },
      doRestore (action, data, index) {
        this.$events.fire('restore-set', action, data, index)
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
