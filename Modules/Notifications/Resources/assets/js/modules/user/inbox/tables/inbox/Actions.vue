<template>
    <div class="list-icons">
        <a href="javascript:;" class="btn btn-outline btn-sm bg-teal text-teal-800 btn-icon ml-2" @click="doMark(rowData.id)" v-if="mark_as_read" data-popup="tooltip" :title="trans('button.mark_as_read')"><i class="icon-checkbox-checked"></i></a>
        <a href="javascript:;" class="btn btn-outline btn-sm bg-danger text-danger-800 btn-icon ml-2" @click="doDelete(rowData.id)" v-if="can_delete" data-popup="tooltip" :title="trans('button.delete')"><i class="icon-cancel-circle2"></i></a>
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
      mark_as_read () {
        return this.rowData.user_id === this.user.id && !this.rowData.is_read
      },
      can_delete () {
        return this.rowData.user_id === this.user.id
      }
    },
    methods: {
      doMark (action, data, index) {
        this.$events.fire('mark-as-read-set', action, data, index)
      },
      doDelete (id) {
        this.$events.fire('delete-set', id)
      }
    }
  }
</script>

<style>
</style>
