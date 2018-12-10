<template>
    <div class="list-icons">
        <router-link class="btn btn-outline btn-sm bg-teal text-teal-800 btn-icon ml-2" :to="{name: 'root.edit', params: { id: rowData.id }}"  v-if="can_edit" data-popup="tooltip" :title="trans('labels.edit')"><i class="icon-pencil7"></i></router-link>
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
      doView (action, data, index) {
        this.$events.fire('view-set', action, data, index)
      },
      doDelete (id) {
        this.$events.fire('delete-set', id)
      },
      doDestroy (id) {
        this.$events.fire('destroy-set', id)
      },
      doRestore (id) {
        this.$events.fire('restore-set', id)
      },
      hasPermissionTo (permission) {
        return this.user.hasOwnProperty('permissions') && this.user.permissions[permission]
      }
    }
  }
</script>

<style>
</style>
