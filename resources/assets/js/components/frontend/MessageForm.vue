<template>
    <div class="input-group">
        <textarea style="resize:none;height:100px;" id="btn-input" type="text" name="message" class="form-control input-sm" placeholder="Type your message here..." v-model="newMessage"></textarea>
        <input id="edit-val" style="display: none;">
        <span class="input-group-btn">
            <button class="btn btn-primary btn-sm button-show" id="btn-chat" @click="sendMessage">
                Send
            </button>
            <button class="btn btn-primary btn-sm button-hide" id="btn-chat" @click="cancel">
                Cancel
            </button>
            <button class="btn btn-primary btn-sm button-hide" id="btn-chat" @click="updateMessage">
                Save
            </button>
        </span>
    </div>
</template>

<script>
    export default {
        
        data() {
            return {
                newMessage: ''
            }
        },

        props: ['messages', 'userid', 'wishid', 'groupid', 'username'],

        methods: {
            sendMessage() {
                var data = {
                    user_id: this.userid,
                    wish_id: this.wishid,
                    group_id: this.groupid,
                    message: this.newMessage
                }
                    
                axios.post('/messages', data).then(response => {
                    
                    var d = new Date();
                    var e = d.toUTCString();
                    var date;
                    date = e.split('GMT').slice(0, 4).join(' ');

                    var html = '<li class="left"><span v-on:click="deleteMessage(message.id)" class="close_button" style="float: right;cursor: pointer;"><i class="fa fa-times"></i></span><span  class="edit_button" style="margin-right: 15px;float: right;cursor: pointer;"><i class="fa fa-pencil"></i></span><div class="chat-body clearfix"><span style="display: block;font-weight: 700;">'+this.username+'</span><span style="display: block;color: #ccc;font-size: 12px;">'+date+'</span><p>'+data.message+'</p></div></li>';
                    jQuery('.chat').append(html)


                });

                this.newMessage = ''
            },

            cancel() {
                $('#btn-input').val('');
                
                $('.button-show').css('display','block')
                $('.button-hide').css('display','none')
            },

            updateMessage() {
                var message = this.newMessage;
                var messageid = $('#edit-val').val();
                
                axios.post('/message/edit/'+messageid+'/'+message).then(resp => {
                    
                    $('#btn-input').val('');

                    jQuery('#'+messageid+" p").text(message);
                    
                    $('.button-show').css('display','block')
                    $('.button-hide').css('display','none')
                });    
            }
        }
        
    }
</script>

<style scoped>
    .input-group {
        display: block;
    }

    .input-group-btn {
        text-align: right;
    }

    #btn-chat {
        margin-top: 15px;
    }

    .button-show{
        float: right;
    }

    .button-hide {
        display: none;
    }
    
    .button-hide:last-child {
        margin-left: 10px;
    }

</style>