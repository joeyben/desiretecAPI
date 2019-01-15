<template>
    <!-- Inner container -->
    <div>
        <vue-datatable></vue-datatable>
    </div>
    <!-- /inner container -->
</template>

<script>
  import Vuex from 'vuex'
  import VueDatatable from '../tables/whitelabels/VueDatatable'
  export default {
    name: 'WhitelabelsComponent',
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
