<template>
    <span>
        <span v-if="rowData.status"><i class="icon-checkmark-circle text-success"></i></span>
        <span v-if="!rowData.status"><i class="icon-cancel-circle2 text-danger"></i></span>
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
