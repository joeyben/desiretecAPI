<template>
    <span>
        <span v-text="rowData.whitelabel_host['host']"></span>
    </span>
</template>

<script>
  import Vuex from 'vuex'
  export default {
    name: 'CustomHost',
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
      })
    },
    methods: {
    }
  }
</script>
