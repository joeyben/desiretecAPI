<template v-if="backendAnalytics && backendAnalytics.data">
    <!-- Large modal -->
    <div style="width:100%;height: 100%;">
        <h1>Backend Analytics</h1>
        <div class="card card-body backend-analytics">
            <div class="backend-analytics__item">
                <h3 class="mb-0">{{backendAnalytics.data.created_wishes}}</h3>
                <span class="text-uppercase font-size-xs">{{trans('labels.frontend.dashboard.analytics.created_wishes')}}</span>
            </div>

            <div class="backend-analytics__item">
                <h3 class="mb-0">{{backendAnalytics.data.changed_wishes}}</h3>
                <span class="text-uppercase font-size-xs">{{trans('labels.frontend.dashboard.analytics.changed_wishes')}}</span>
            </div>

            <div class="backend-analytics__item">
                <h3 class="mb-0">{{backendAnalytics.data.free_text}}</h3>
                <span class="text-uppercase font-size-xs">{{trans('labels.frontend.dashboard.analytics.free_text')}}</span>
            </div>

            <div class="backend-analytics__item">
                <h3 class="mb-0">{{backendAnalytics.data.answered_wishes}}</h3>
                <span class="text-uppercase font-size-xs">{{trans('labels.frontend.dashboard.analytics.answered_wishes')}}</span>
            </div>

            <div class="backend-analytics__item">
                <h3 class="mb-0">{{backendAnalytics.data.reaction_quota}}</h3>
                <span class="text-uppercase font-size-xs">{{trans('labels.frontend.dashboard.analytics.reaction_quota')}}</span>
            </div>

            <div class="backend-analytics__item">
                <h3 class="mb-0">{{backendAnalytics.data.latest_answered_wishes}}</h3>
                <span class="text-uppercase font-size-xs">{{trans('labels.frontend.dashboard.analytics.latest_answered_wishes')}}</span>
            </div>

            <div class="backend-analytics__item">
                <h3 class="mb-0">{{backendAnalytics.data.latest_reaction_quota}}</h3>
                <span class="text-uppercase font-size-xs">{{trans('labels.frontend.dashboard.analytics.latest_reaction_quota')}}</span>
            </div>

            <div class="backend-analytics__item">
                <h3 class="mb-0">{{backendAnalytics.data.bookings}}</h3>
                <span class="text-uppercase font-size-xs">{{trans('labels.frontend.dashboard.analytics.bookings')}}</span>
            </div>

            <div class="backend-analytics__reaction-time">
                <h3>{{trans('labels.frontend.dashboard.analytics.reaction_time')}}</h3>

                <ul>
                    <li v-for="item in backendAnalytics.data.reaction_time">
                        {{item.title}} - {{item.diff_hours}}h
                    </li>
                </ul>

            </div>
        </div>
    </div>
    <!-- /large modal -->
</template>
<script>
  import Vuex from 'vuex'
  import { Errors } from '../../../../../../../../../resources/assets/js/utils/errors'
  export default {
    name: 'BackendAnalyticsComponent',
    components: { },
    data () {
      return {
        // eslint-disable-next-line
        errors: new Errors()
      }
    },
    mounted () {
      this.loadBackendAnalytics()
    },
    watch: {
    },
    computed: {
      ...Vuex.mapGetters({
        backendAnalytics: 'backendAnalytics'
      })
    },
    methods: {
      ...Vuex.mapActions({
        loadBackendAnalytics: 'loadBackendAnalytics'
      })
    }
  }
</script>

<style>
    .backend-analytics {
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
    }

    .backend-analytics__item {
        width: 200px;
        margin: 20px;
    }

    .backend-analytics__reaction-time {
        width: 100%;
        max-height: 200px;
        overflow-y: auto;
    }
</style>
