<template>
    <div>
        <div class="col-md-12" :id="message.id" v-for="message in messages" :key="message.id">
            <div v-bind:class="[userid == message.user_id ?  'cu-img-right' : 'cu-img-left']">
                <img v-if="message.avatar" :src="message.avatar">
                <img v-else :src="'/img/frontend/profile-picture/user.png'">
            </div>      
        
            <div v-bind:class="[userid == message.user_id ?  'cu-comment-right' : 'cu-comment-left']">
                <p>
                <span>{{ message.created_at }} Uhr</span>
                {{ message.message }}
                </p>
            </div>  
        </div>
        <message-form v-on:messaged="updateMessages" :username="this.user" :userid="userid" :wishid="wishid" :groupid="groupid"></message-form>
    </div>
</template>

<script>

  import MessageForm from './MessageForm.vue'
  import ConfirmationModal from './ConfirmationModal.vue'
  import moment from 'moment'

Vue.prototype.moment = moment

  export default {
    data () {
      return {
        messages: [],
        user: '',
        avatar: []
      }
    },

    props: ['userid', 'wishid', 'groupid'],

    mounted() {
        this.fetchMessages();

    },

    methods: {

        fetchMessages() {
            axios.get('/messages/'+this.wishid+'/'+this.groupid).then(response => {
                this.messages = response.data.data;
                this.user = response.data.user;
                this.avatar = response.data.avatar;
            });
        },

        editMessage(messageid, message) {

            $('#btn-input').val('');
            $('#btn-input').val(jQuery('#'+messageid+" .chat-body p").text());
            $('#edit-val').val(messageid);

            $('.button-show').css('display','none')
            $('.button-hide').css('display','inline-block')

            $('html, body').animate({scrollTop: $('.input-group').offset().top - 80}, 1000);            
        },

        showModal(id) {
            $('.hidden-popup-val').val(id)
            $('.confirm-popup').show();
            $('body').css('overflow', 'hidden');
        },
         
        updateMessages () {
            
            this.fetchMessages();
        },

        timestamp(date) {
            return moment(date).fromNow();

        }

    }
  };
</script>

<style scoped>

    .chat{
        list-style: none;
        padding-left: 0px;
    }

    .user{
            display: block;
            font-weight: 700;
    }

    .date-created{
            display: block;
            color: #ccc;
            font-size: 12px;
    }

    .close_button i{
        float: right;
        cursor: pointer;
    }

    .edit_button i{
        margin-right: 15px;
        float: right;
        cursor: pointer;
    }

</style>