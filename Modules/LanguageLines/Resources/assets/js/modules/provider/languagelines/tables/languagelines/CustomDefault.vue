<template>
    <span>
        <span v-if="rowData.default"><i class="icon-checkmark-circle text-success"></i></span>
    </span>
</template>

<script>
  export default {
    name: 'CustomDefault',
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
