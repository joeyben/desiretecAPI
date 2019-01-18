<template>
    <!-- Large modal -->
    <div>
        ddfd
    </div>
    <!-- /large modal -->
</template>
<script>
  import Vuex from 'vuex'
  import { Errors } from '../../../../../../../../../resources/assets/js/utils/errors'
  export default {
    name: 'Second',
    components: { },
    data () {
      return {
        // eslint-disable-next-line
        errors: new Errors(),
      }
    },
    mounted () {
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
        addWhitelabel: 'addWhitelabel'
      })
    }
  }
</script>
