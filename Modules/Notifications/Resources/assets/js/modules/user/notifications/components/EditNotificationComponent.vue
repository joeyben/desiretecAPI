<template>
    <!-- Large modal -->
    <div id="modal_large_notification" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="icon-menu7 mr-2"></i> &nbsp;Modal with icons</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body bg-white">
                    <div>
                        <p class="text-black-50" v-html="notification.message"></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger btn-sm" data-dismiss="modal"><i class="icon-cancel-circle2 mr-1"></i> {{ trans('button.close') }}</button>
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
    name: 'EditNotificationComponent',
    components: { },
    data () {
      return {
        // eslint-disable-next-line
        errors: new Errors()
      }
    },
    mounted () {
      this.loadModal()
    },
    watch: {
      '$route.params.id' () {
        this.EditNotification(parseInt(this.$route.params.id))
      }
    },
    computed: {
      ...Vuex.mapGetters({
        notification: 'notification',
        user: 'currentUser'
      })
    },
    methods: {
      ...Vuex.mapActions({
        addNotification: 'addNotification'
      }),
      loadModal () {
        let id = parseInt(this.$route.params.id)
        $('#modal_large_notification').on('hidden.bs.modal', () => {
          this.$router.push({name: 'root'})
        })

        if (id !== 0) {
          this.EditNotification(id)
        }
      },
      EditNotification (id) {
        this.$store.dispatch('block', {element: 'notificationsComponent', load: true})
        this.$http.get(window.laroute.route('notifications.edit', {id: id}))
          .then(this.onLoadNotificationSuccess)
          .catch(this.onFailed)
          .then(() => {
            this.$store.dispatch('block', {element: 'notificationsComponent', load: false})
          })
      },
      onLoadNotificationSuccess (response) {
        if (response.data.hasOwnProperty('success') && response.data.success === true) {
          this.addNotification(response.data.notification)
          if (!($('#modal_large_notification').data('bs.modal') || {}).isShown) {
            $('#modal_large_notification').modal('show')
          }
        } else {
          this.$notify.error({ title: 'Failed', message: response.data.message })
        }
      },
      onFailed (error) {
        if (error.response !== undefined && error.response.hasOwnProperty('data') && error.response.data.hasOwnProperty('errors')) {
          this.errors.record(error.response.data.errors)
          if (error.response.data.hasOwnProperty('success') && error.response.data.hasOwnProperty('message')) {
            this.$notify.error({ title: 'Failed', message: error.response.data.message })
          } else {
            this.$notify.error({ title: 'Failed', dangerouslyUseHTMLString: true, message: this.errors.getErrors(this.errors.errors) })
          }
        } else if (error.response !== undefined && error.response.hasOwnProperty('data') && error.response.data.hasOwnProperty('message')) {
          this.$notify.error({ title: 'Failed', message: error.response.data.message })
        } else if (error.hasOwnProperty('message')) {
          this.$notify.error({ title: 'Error', message: error.message })
        } else {
          this.$notify.error({ title: 'Failed', message: 'Service not answer, Please contact your Support' })
          console.log(error)
        }
      }
    }
  }
</script>
