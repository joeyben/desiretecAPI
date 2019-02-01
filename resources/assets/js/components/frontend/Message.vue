<template>
     <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Communicate with Agent</div>

                    <div class="panel-body">
                        <chat-messages :messages="messages" :avatar="avatar"></chat-messages>
                    </div>
                    <div class="panel-footer">
                        <message-form></message-form>
                    </div>
                </div>
            </div>
        </div>
</template>

<script>

export default {
    data () {
      return {
        messages: [],
        avatar: []
      }
    },
    mounted() {
        this.fetchMessages();
    },

    methods: {
        fetchMessages() {
            axios.get('/messages').then(response => {
                this.messages = response.data.data;
                this.avatar = response.data.avatar;
            })
        }
    }
}
</script>

<style scoped>
    .panel{
        margin-bottom: 0;
    }
</style>