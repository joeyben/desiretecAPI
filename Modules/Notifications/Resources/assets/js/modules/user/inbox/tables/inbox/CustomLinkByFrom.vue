<template>
    <span>
      <span class="btn rounded-circle btn-icon btn-sm" :class="rowData.is_read ? 'bg-teal-300' : 'bg-teal-800'">
           <span class="letter-icon text-uppercase">{{ letter }}</span>
      </span>
        <span :class="rowData.is_read ? '' : 'font-weight-bold'">
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
