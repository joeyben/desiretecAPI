<template>
    <ul class="list list-unstyled mb-0 text-teal-800">
        <li v-for="user in rowData.users"> <i class="icon-user-check mr-2"></i> {{ user.full_name }}</li>
    </ul>
</template>

<script>
  export default {
    name: 'CustomUsers',
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
