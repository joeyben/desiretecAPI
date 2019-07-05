<template>
    <!-- Inner container -->
    <div>
        <vue-datatable></vue-datatable>
        <router-view></router-view>
    </div>
    <!-- /inner container -->
</template>
<style>
    .el-select.is-invalid {
        border-color: #f44336 !important;
    }
    .help-block-invalid {
        width: 100%;
        margin-top: .5rem;
        font-size: 80%;
        color: #f44336;
    }
</style>
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
