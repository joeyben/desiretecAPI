<template>
    <span>
        <span v-text="rowData.layer_whitelabel['layer'].name"></span>
    </span>
</template>

<script>
  export default {
    name: 'CustomStatus',
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
    methods: {
    }
  }
</script>
