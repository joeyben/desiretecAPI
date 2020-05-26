<template>
    <span>
        <span v-text="rowData.layer_whitelabel['layer'].name"></span>
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
        return !this.deleted && this.hasPermissionTo('update-wish')
      }
    },
    methods: {
      hasPermissionTo (permission) {
        return this.user.hasOwnProperty('permissions') && this.user.permissions[permission]
      }
    }
  }
</script>
