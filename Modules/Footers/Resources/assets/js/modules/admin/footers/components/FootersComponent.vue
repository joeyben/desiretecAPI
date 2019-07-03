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
  import VueDatatable from '../tables/footers/VueDatatable'
  export default {
    name: 'FootersComponent',
    components: { VueDatatable },
    data () {
      return {
      }
    },
    mounted () {
      this.loadUser()
      this.loadWhitelabels()
    },
    watch: {
    },
    computed: {
      ...Vuex.mapGetters({
      })
    },
    methods: {
      ...Vuex.mapActions({
        loadUser: 'loadLoggedUser',
        loadWhitelabels: 'loadWhitelabels'
      })
    }
  }
</script>
