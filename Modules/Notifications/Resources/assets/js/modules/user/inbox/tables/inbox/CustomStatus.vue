<template>
    <span>
        <span>
              <i class="icon-star-full2 text-warning-300"></i>
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
