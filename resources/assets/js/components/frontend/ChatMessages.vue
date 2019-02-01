<template>
    <div>
        <ul class="chat">
            <li :id="message.id" class="left" v-for="message in messages" :key="message.id">
                    <div v-if="message.user_id == userid">
                    <span v-on:click="showModal(message.id)" class="close_button">
                        <i class="fa fa-times"></i>
                    </span>
                    <span v-on:click="editMessage(message.id, message.message)" class="edit_button">
                        <i class="fa fa-pencil"></i>
                    </span>

                    <confirmation-modal v-on:confirm="updateMessages" :id="message.id"></confirmation-modal>
                </div>
                <div class="chat-body clearfix">
                    <img v-if="message.avatar" :src="message.avatar">
                    <img v-else src="https://www.thehindu.com/sci-tech/technology/internet/article17759222.ece/alternates/FREE_660/02th-egg-person">
                    <span v-if="message.first_name == null" class="user">{{ message.display_name }}</span>
                    <span v-else class="user">{{ message.first_name }}</span>
                    <span class="date-created">{{ timestamp(message.created_at) }}</span>
                    <p>{{ message.message }}</p>
                </div>
               <hr>
            </li>
            
        </ul>
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
            $('#btn-input').val(message);
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