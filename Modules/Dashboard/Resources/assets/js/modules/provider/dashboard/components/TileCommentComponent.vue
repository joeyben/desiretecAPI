<template>
    <!-- Large modal -->
    <div class="card card-body bg-blue-400 has-bg-image">
        <div class="media">
            <div class="media-body">
                <h3 class="mb-0">54,390</h3>
                <span class="text-uppercase font-size-xs">total comments</span>
            </div>

            <div class="ml-3 align-self-center">
                <i class="icon-bubbles4 icon-3x opacity-75"></i>
            </div>
        </div>
    </div>
    <!-- /large modal -->
</template>
<script>
  import Vuex from 'vuex'
  import { Errors } from '../../../../../../../../../resources/assets/js/utils/errors'
  export default {
    name: 'TileCommentComponent',
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
