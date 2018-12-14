<template>
    <div class="list-icons">
        <a href="javascript:;" class="btn btn-outline btn-sm bg-teal text-teal-800 btn-icon ml-2" v-if="rowData.status" @click="doMigrate(rowData.name)" data-popup="tooltip" :title="trans('tables.migrate')"><i class="icon-database-refresh"></i></a>
        <a href="javascript:;" class="btn btn-outline btn-sm bg-teal text-teal-800 btn-icon ml-2" v-if="!rowData.status" @click="doInstall(rowData.name)" data-popup="tooltip" :title="trans('tables.install')"><i class="icon-play3"></i></a>
        <a href="javascript:;" class="btn btn-outline btn-sm bg-danger text-danger-800 btn-icon ml-2" v-if="rowData.status" @click="doUninstall(rowData.name)" data-popup="tooltip" :title="trans('tables.uninstall')"><i class="icon-cancel-circle2"></i></a>
    </div>
</template>

<script>
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
    },
    methods: {
      doMigrate (name) {
        this.$events.fire('migrate-set', name)
      },
      doInstall (name) {
        this.$events.fire('install-set', name)
      },
      doView (action, data, index) {
        this.$events.fire('view-set', action, data, index)
      },
      doUninstall (id) {
        this.$events.fire('uninstall-set', id)
      }
    }
  }
</script>

<style>
</style>
