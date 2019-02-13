<template>
    <!-- Inner container -->
    <li class="media">
        <div class="mr-3">
            <span class="btn bg-teal-400 rounded-circle btn-icon btn-sm">
               <span class="letter-icon text-uppercase">{{ letter }}</span>
           </span>
        </div>

        <div class="media-body">
            <div v-html="notification.message"></div>
            <div class="text-muted font-size-sm" v-text="formatDate(notification.created_at)"></div>
        </div>
    </li>
    <!-- /inner container -->
</template>

<script>
  import Vuex from 'vuex'
  import moment from 'moment'
  moment.locale(window.i18.lang)
  export default {
    name: 'NotificationComponent',
    components: { },
    props: {
      notification: {
        type: Object,
        required: true
      }
    },
    data () {
      return {
      }
    },
    mounted () {

    },
    watch: {
    },
    computed: {
      ...Vuex.mapGetters({
      }),
      from () {
        return this.notification.hasOwnProperty('from') && this.notification.from !== null ? this.notification.from.full_name : ''
      },
      letter () {
        return this.from.length > 1 ? this.from.slice(0, 2) : ''
      }
    },
    methods: {
      ...Vuex.mapActions({
      }),
      formatDate (value, fmt = 'D MMM YYYY') {
        return (value == null)
          ? ''
          : moment(value, moment.ISO_8601).fromNow()
      }
    }
  }
</script>
