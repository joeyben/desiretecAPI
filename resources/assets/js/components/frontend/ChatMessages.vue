<template>
    <div>
        <ul class="chat">
            <li :id="message.id" class="left" v-for="message in messages" :key="message.id">
                <span v-on:click="deleteMessage(message.id)" class="close_button">
                    <i class="fa fa-times"></i>
                </span>
                <span v-on:click="editMessage(message.id, message.message)" class="edit_button">
                    <i class="fa fa-pencil"></i>
                </span>
                
                <div class="chat-body clearfix">
                    <span class="user">{{ message.first_name }}</span>
                    <span class="date-created">{{ message.created_at }}</span>
                
                    <p>
                        {{ message.message }}
                    </p>
                    
                    
                </div>
            </li>
        </ul>
        <message-form :username="this.user" :userid="userid" :wishid="wishid" :groupid="groupid"></message-form>
    </div>
</template>

<script>

  import MessageForm from './MessageForm.vue'

  export default {
    data () {
      return {
        messages: [],
        user: ''
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
            });
        },

        deleteMessage(messageid) {
            axios.get('/message/delete/'+messageid).then(resp => {
                $('#'+messageid).remove();

            });
            
        },

        editMessage(messageid, message) {

            $('#btn-input').val('');
            $('#btn-input').val(message);
            $('#edit-val').val(messageid);

            $('.button-show').css('display','none')
            $('.button-hide').css('display','inline-block')

            $('html, body').animate({scrollTop: $('.input-group').offset().top - 80}, 1000);            
        }

    }
  };
</script>

<style scoped>

    .chat{
        list-style: none;
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