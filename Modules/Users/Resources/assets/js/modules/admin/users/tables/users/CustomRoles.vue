<template>
    <ul class="list list-unstyled mb-0 text-teal-800">
        <li v-for="role in rowData.roles"> <i class="icon-trophy4"></i> {{ role.name }}</li>
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
