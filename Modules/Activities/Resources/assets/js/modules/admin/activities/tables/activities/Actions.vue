<template>
    <div class="list-icons">
        <a href="javascript:;" class="btn btn-outline btn-sm bg-slate-400 text-slate-800 btn-icon ml-2" @click="doView('view-item', rowData, rowIndex)" data-popup="tooltip" :title="trans('labels.read_more')"><i class="icon-search4"></i></a>
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
      })
    },
    methods: {
      doView (action, data, index) {
        this.$events.fire('view-set', action, data, index)
      }
    }
  }
</script>

<style>
</style>
