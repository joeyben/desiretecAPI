<template>
    <span>
      <span class="btn bg-teal-400 rounded-circle btn-icon btn-sm">
           <span class="letter-icon text-uppercase">{{ letter }}</span>
      </span>
        <span>
             {{ from }}
        </span>
    </span>
</template>

<script>
  export default {
    name: 'CustomLinkByFrom',
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
      from () {
        return this.rowData.hasOwnProperty('from') && this.rowData.from !== null ? this.rowData.from.full_name : ''
      },
      letter () {
        return this.from.length > 1 ? this.from.slice(0, 2) : ''
      }
    },
    methods: {
    }
  }
</script>
