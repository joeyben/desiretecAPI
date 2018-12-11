<template>
    <!-- List of latest updates -->
    <div class="card" style="max-width: 573px;max-height:400px;overflow-y:scroll;">
        <div class="card-header header-elements-inline">
            <h6 class="card-title">Latest updates</h6>

            <div class="header-elements">
                <a href="#">All updates</a>
            </div>
        </div>

        <div class="card-body">
            <ul class="media-list">
                <li class="media">
                    <div class="mr-3">
                        <a href="#" class="btn bg-transparent border-primary text-primary rounded-round border-2 btn-icon">
                            <i class="icon-spinner11"></i>
                        </a>
                    </div>

                    <div class="media-body">
                        <a href="#">David Linner</a> requested refund for a double card charge
                        <div class="text-muted font-size-sm">12 minutes ago</div>
                    </div>
                </li>

                <li class="media">
                    <div class="mr-3">
                        <a href="#" class="btn bg-transparent border-danger text-danger rounded-round border-2 btn-icon">
                            <i class="icon-infinite"></i>
                        </a>
                    </div>

                    <div class="media-body">
                        User <a href="#">Christopher Wallace</a> is awaiting for staff reply
                        <div class="text-muted font-size-sm">16 minutes ago</div>
                    </div>
                </li>

                <li class="media">
                    <div class="mr-3">
                        <a href="#" class="btn bg-transparent border-slate text-slate rounded-round border-2 btn-icon">
                            <i class="icon-cash3"></i>
                        </a>
                    </div>

                    <div class="media-body">
                        All sellers have received monthly payouts
                        <div class="text-muted font-size-sm">4 hours ago</div>
                    </div>
                </li>

                <li class="media">
                    <div class="mr-3">
                        <a href="#" class="btn bg-transparent border-success text-success rounded-round border-2 btn-icon">
                            <i class="icon-checkmark3"></i>
                        </a>
                    </div>

                    <div class="media-body">
                        Ticket #43683 has been closed by <a href="#">Victoria Wilson</a>
                        <div class="text-muted font-size-sm">Apr 28, 21:39</div>
                    </div>
                </li>

                <li class="media">
                    <div class="mr-3">
                        <a href="#" class="btn bg-transparent border-indigo-400 text-indigo-400 rounded-round border-2 btn-icon">
                            <i class="icon-comment"></i>
                        </a>
                    </div>

                    <div class="media-body">
                        <a href="#">Beatrix Diaz</a> left a new feedback for Camo backpack
                        <div class="text-muted font-size-sm">Mar 30, 05:46</div>
                    </div>
                </li>
                <li class="media">
                    <div class="mr-3">
                        <a href="#" class="btn bg-transparent border-indigo-400 text-indigo-400 rounded-round border-2 btn-icon">
                            <i class="icon-comment"></i>
                        </a>
                    </div>

                    <div class="media-body">
                        <a href="#">Beatrix Diaz</a> left a new feedback for Camo backpack
                        <div class="text-muted font-size-sm">Mar 30, 05:46</div>
                    </div>
                </li>
                <li class="media">
                    <div class="mr-3">
                        <a href="#" class="btn bg-transparent border-indigo-400 text-indigo-400 rounded-round border-2 btn-icon">
                            <i class="icon-comment"></i>
                        </a>
                    </div>

                    <div class="media-body">
                        <a href="#">Beatrix Diaz</a> left a new feedback for Camo backpack
                        <div class="text-muted font-size-sm">Mar 30, 05:46</div>
                    </div>
                </li>
                <li class="media">
                    <div class="mr-3">
                        <a href="#" class="btn bg-transparent border-indigo-400 text-indigo-400 rounded-round border-2 btn-icon">
                            <i class="icon-comment"></i>
                        </a>
                    </div>

                    <div class="media-body">
                        <a href="#">Beatrix Diaz</a> left a new feedback for Camo backpack
                        <div class="text-muted font-size-sm">Mar 30, 05:46</div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <!-- /list of latest updates -->
</template>
<script>
  import Vuex from 'vuex'
  import { Errors } from '../../../../../../../../../resources/assets/js/utils/errors'
  export default {
    name: 'TileUpdateComponent',
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
