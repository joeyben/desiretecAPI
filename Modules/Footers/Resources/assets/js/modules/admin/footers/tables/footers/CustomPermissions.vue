<template>
    <ul class="list list-unstyled mb-0 text-teal-300">
        <li v-if="rowData.all === 1"><i class="icon-checkmark-circle text-success"></i>
            <span class="badge badge-success">All</span>
        </li>
        <li v-for="permission in rowData.permissions" v-if="rowData.all === 0"> <i class="icon-checkmark-circle text-success"></i> {{ permission.display_name }}</li>
    </ul>
</template>

<script>
  export default {
    name: 'CustomPermissions',
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
