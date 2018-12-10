<template>
    <span>
        <router-link :to="{name: 'root.edit', params: { id: rowData.id }}" data-popup="tooltip" :title="rowData.title" v-if="can_edit">{{ rowData.title | str_limit(40) }}</router-link>
        <span v-if="!can_edit && !deleted">{{ rowData.title | str_limit(40) }}</span>
        <s class="text-danger"  v-if="deleted">{{ rowData.title | str_limit(40) }}</s>
    </span>
</template>

<script>
    import Vuex from 'vuex'
    export default {
      name: 'CustomLinkByTitle',
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
