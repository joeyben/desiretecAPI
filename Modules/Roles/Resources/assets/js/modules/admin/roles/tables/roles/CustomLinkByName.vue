<template>
    <span>
        <a :href="editUrl" v-if="can_edit" data-popup="tooltip" :title="rowData.name" v-text="rowData.name"></a>
        <span v-if="!can_edit && !deleted">{{ rowData.name | str_limit(40) }}</span>
        <s class="text-danger"  v-if="deleted">{{ rowData.name | str_limit(40) }}</s>
    </span>
</template>

<script>
  import Vuex from 'vuex'
  export default {
    name: 'CustomLinkByName',
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
