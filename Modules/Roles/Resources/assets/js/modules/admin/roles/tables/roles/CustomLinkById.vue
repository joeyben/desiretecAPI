<template>
    <span>
        <a :href="editUrl" v-if="can_edit" data-popup="tooltip" :title="rowData.id" v-text="rowData.id"></a>
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
      deleted: function () {
        return this.rowData.deleted_at !== null
      },
      can_edit () {
        return !this.deleted && this.hasPermissionTo('edit-role')
      },
      editUrl () {
        return window.laroute.route('admin.access.role.edit', {role: this.rowData.id})
      }
    },
    methods: {
      hasPermissionTo (permission) {
        return this.user.hasOwnProperty('permissions') && this.user.permissions[permission]
      }
    }
  }
</script>
