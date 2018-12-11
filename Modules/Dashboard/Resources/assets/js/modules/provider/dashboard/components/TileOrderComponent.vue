<template>
    <!-- Large modal -->
    <div style="width:100%;height: 100%;">
        <div class="card card-body">
            <div class="media">
                <div class="media-body">
                    <h3 class="font-weight-semibold mb-0">389,438</h3>
                    <span class="text-uppercase font-size-sm text-muted">total orders</span>
                </div>

                <div class="ml-3 align-self-center">
                    <i class="icon-bag icon-3x text-danger-400"></i>
                </div>
            </div>
        </div>
    </div>
    <!-- /large modal -->
</template>
<script>
  import Vuex from 'vuex'
  import { Errors } from '../../../../../../../../../resources/assets/js/utils/errors'
  export default {
    name: 'TileClickComponent',
    components: { },
    data () {
      return {
        // eslint-disable-next-line
        errors: new Errors()
      }
    },
    mounted () {
    },
    watch: {
    },
    computed: {
      ...Vuex.mapGetters({
      })
    },
    methods: {
      ...Vuex.mapActions({
      })
    }
  }
</script>
