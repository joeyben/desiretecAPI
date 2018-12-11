<template>
    <!-- Large modal -->
    <div style="width:100%;height: 100%;">
        <div class="card card-body bg-success-400 has-bg-image">
            <div class="media">
                <div class="mr-3 align-self-center">
                    <i class="icon-pointer icon-3x opacity-75"></i>
                </div>

                <div class="media-body text-right">
                    <h3 class="mb-0">652,549</h3>
                    <span class="text-uppercase font-size-xs">total clicks</span>
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
