<template>
    <!-- Inner container -->
    <div>
        <vue-datatable></vue-datatable>
    </div>
    <!-- /inner container -->
</template>

<script>
  import Vuex from 'vuex'
  import VueDatatable from '../tables/inbox/VueDatatable'
  export default {
    name: 'InboxComponent',
    components: { VueDatatable },
    data () {
      return {
      }
    },
    mounted () {
      this.loadUser()
    },
    watch: {
    },
    computed: {
      ...Vuex.mapGetters({
      })
    },
    methods: {
      ...Vuex.mapActions({
        loadUser: 'loadLoggedUser'
      })
    }
  }
</script>
