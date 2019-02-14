<template>
    <span>
        <span v-if="!rowData.is_read">
              <i class="icon-star-full2 text-warning-300"></i>
        </span>
        <span v-if="rowData.is_read">
              <i class="icon-star-empty3 text-muted"></i>
        </span>
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
    computed: {
    },
    methods: {
    }
  }
</script>
