<template>
    <div class="col-md-12">
        <textarea name="antworten" id="antworten" v-model="newMessage"></textarea>
        <div class="cu-cl-buttons">
            <button class="primary-btn antworten-btn button-show" id="btn-chat" @click="sendMessage">Nachricht schreiben</button>
            <button class="primary-btn antworten-btn  button-hide" id="btn-chat" @click="updateMessage">Speichern</button>
        </div>
    </div>
</template>

<script>
    export default {
        
        data() {
            return {
                newMessage: ''
            }
        },

        props: ['messages', 'userid', 'wishid', 'groupid', 'username', 'fetch'],

        methods: {
            sendMessage() {
                var data = {
                    user_id: this.userid,
                    wish_id: this.wishid,
                    group_id: this.groupid,
                    message: this.newMessage
                }

                $('.button-show span').css('display', 'none');
                $('.loader').css('display', 'block');
                    
                axios.post('/messages', data).then(response => {
                    $('.loader').css('display','none');
                    $('.button-show span').css('display', 'block');
                    this.$emit('messaged', response.data.data);

                });

                this.newMessage = ''
            },

            cancel() {
                $('#btn-input').val('');
                
                $('.button-show span').show();
                $('.loader').hide();
            },

            updateMessage() {
                var message = this.newMessage;
                var messageid = $('#edit-val').val();
                
                axios.post('/message/edit/'+messageid+'/'+message).then(resp => {

                    $('#antworten').val('');
                    $('#antworten').slideUp()

                    jQuery('#'+messageid+" .message-holder").text(message);

                    $('.button-show').css('display','inline-block')
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

    .button-hide {
        display: none;
    }
    
    .button-hide:last-child {
        margin-left: 10px;
    }
    .loader {
        display:none;
        border: 2px solid #f3f3f3;
        border-radius: 50%;
        border-top: 2px solid #3498db;
        width: 18px;
        height: 18px;
        -webkit-animation: spin 2s linear infinite; /* Safari */
        animation: spin 2s linear infinite;
    }

    /* Safari */
    @-webkit-keyframes spin {
        0% { -webkit-transform: rotate(0deg); }
        100% { -webkit-transform: rotate(360deg); }
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>