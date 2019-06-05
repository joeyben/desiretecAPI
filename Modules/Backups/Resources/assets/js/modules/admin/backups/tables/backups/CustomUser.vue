<template>
    <span>
        <span v-if="active">{{ name | str_limit(40) }}</span>
        <s class="text-danger"  v-if="!active">{{ name | str_limit(40) }}</s>
    </span>
</template>

<script>
  export default {
    name: 'CustomUser',
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
      active: function () {
        return this.rowData.hasOwnProperty('user') && this.rowData.user !== null && this.rowData.user['active']
      },
      name () {
        return this.rowData.hasOwnProperty('user') && this.rowData.user !== null ? this.rowData.user['full_name'] : ''
      }
    },
    methods: {
    }
  }
</script>
