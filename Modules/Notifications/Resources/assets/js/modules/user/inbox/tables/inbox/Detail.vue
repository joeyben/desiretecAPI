<template>
    <div @click="onClick">
        <div class="inline field">
            <label class="font-weight-bold">{{ lang('tables.updated_at') }} : </label>
            <span>{{ rowData.updated_at }}</span>
        </div>
        <div class="inline field">
            <label class="font-weight-bold">{{ lang('tables.created_at') }} : </label>
            <span>{{ rowData.created_at }}</span>
        </div>
    </div>
</template>

<script>
  export default {
    name: 'Detail',
    props: {
      rowData: {
        type: Object,
        required: true
      },
      rowIndex: {
        type: Number
      }
    },
    methods: {
      onClick (event) {
        console.log('my-detail-row: on-click', event.target)
      },
      lang (key) {
        return window.Lang.get(key)
      },
      getAddress (key) {
        return (this.rowData.hasOwnProperty('addresses')) ? this.rowData.addresses[0][key] : ''
      }
    }
  }
</script>
