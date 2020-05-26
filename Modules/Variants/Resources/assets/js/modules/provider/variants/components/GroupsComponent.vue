<template>
    <!-- Inner container -->
    <div>
        <vue-datatable></vue-datatable>
        <router-view></router-view>
    </div>
    <!-- /inner container -->
</template>

<script>
  import Vuex from 'vuex'
  import VueDatatable from '../tables/groups/VueDatatable'
  export default {
    name: 'GroupsComponent',
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
        user: 'currentUser'
      })
    },
    methods: {
      ...Vuex.mapActions({
        loadUser: 'loadLoggedUser'
      })
    }
  }
</script>
