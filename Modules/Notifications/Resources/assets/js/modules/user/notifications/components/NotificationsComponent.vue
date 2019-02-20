<template>
    <!-- Inner container -->
    <li class="nav-item dropdown">
        <a href="#" class="navbar-nav-link dropdown-toggle caret-0" data-toggle="dropdown">
            <i class="icon-bell3"></i>
            <span class="d-md-none ml-2"> {{ trans('labels.notifications') }}</span>
            <span class="badge badge-pill bg-teal-800 ml-auto ml-md-0" v-text="count" v-if="count > 0"></span>
        </a>

        <div class="dropdown-menu dropdown-menu-right dropdown-content wmin-md-400">
            <div class="dropdown-content-header">
                <span class="font-weight-semibold">{{ trans('labels.notifications') }}</span>
                <a href="#" class="text-default"><i class="icon-sync"></i></a>
            </div>

            <div class="dropdown-content-body dropdown-scrollable">
                <ul class="media-list">
                    <notification-component v-for="notification in notifications" :key="notification.id" :notification="notification"></notification-component>
                </ul>
            </div>

            <div class="dropdown-content-footer justify-content-center p-0">
                <a :href="inboxUrl" class="bg-light text-grey w-100 py-2" data-popup="tooltip" :title="trans('labels.inbox')"><i class="icon-drawer-in d-block top-0"></i></a>
            </div>
        </div>
    </li>
    <!-- /inner container -->
</template>

<script>
  import Vuex from 'vuex'
  import NotificationComponent from './NotificationComponent'
  export default {
    name: 'NotificationsComponent',
    components: { NotificationComponent },
    data () {
      return {
        inboxUrl: window.laroute.route('notifications')
      }
    },
    mounted () {
      this.loadNotifications()
    },
    watch: {
    },
    computed: {
      ...Vuex.mapGetters({
        count: 'count',
        notifications: 'notifications'
      })
    },
    methods: {
      ...Vuex.mapActions({
        loadNotifications: 'loadNotifications'
      })
    }
  }
</script>
