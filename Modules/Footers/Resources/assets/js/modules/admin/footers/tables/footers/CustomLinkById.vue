<template>
    <span>
        <router-link :to="{name: 'root.edit', params: { id: rowData.id }}" data-popup="tooltip" :title="rowData.id" v-if="can_edit" v-text="rowData.id"></router-link>
        <span v-if="!can_edit && !deleted">{{ rowData.id }}</span>
        <s class="text-danger"  v-if="deleted">{{ rowData.id }}</s>
    </span>
</template>

<script>
  import Vuex from 'vuex'
  export default {
    name: 'CustomLinkById',
    props: {
      rowData: {
        type: Object,
        required: true
      },
      rowIndex: {
        type: Number
      }
    },
    data () {
      return {
      }
    },
    computed: {
      ...Vuex.mapGetters({
        user: 'currentUser'
      }),
      can_delete () {
        return !this.deleted && (this.hasRole('Executive') || this.hasRole('Administrator'))
      },
      deleted: function () {
        return this.rowData.deleted_at !== null
      },
      can_edit () {
        return !this.deleted && (this.hasRole('Executive') || this.hasRole('Administrator'))
      },
      editUrl () {
        return window.laroute.route('admin.access.role.edit', {role: this.rowData.id})
      }
    },
    methods: {
      hasPermissionTo (permission) {
        return this.user.hasOwnProperty('permissions') && this.user.permissions[permission]
      },
      hasRole (permission) {
        return this.user.hasOwnProperty('roles') && this.user.roles[permission]
      }
    }
  }
</script>
