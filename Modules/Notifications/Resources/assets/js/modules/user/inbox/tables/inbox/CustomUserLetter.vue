<template>
   <span class="btn bg-teal-400 rounded-circle btn-icon btn-sm">
       <span class="letter-icon text-uppercase">{{ letter }}</span>
   </span>
</template>

<script>
  export default {
    name: 'CustomUserLetter',
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
      letter () {
        return this.rowData.hasOwnProperty('from') && this.rowData.from !== null ? this.rowData.from.full_name.slice(0, 2) : ''
      }
    },
    methods: {
    }
  }
</script>
