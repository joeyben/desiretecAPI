
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('../bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.use(require('vue-moment'));
Vue.component('v-select', require('../../../../node_modules/vue-select/src/components/Select.vue'))
Vue.component('pagination', require('../components/frontend/PaginationComponent.vue'));
Vue.component('comment', require('../components/frontend/Comment.vue'));
Vue.component('message', require('../components/frontend/Message.vue'));
Vue.component('chat-messages', require('../components/frontend/ChatMessages.vue'));
Vue.component('message-form', require('../components/frontend/MessageForm.vue'));
Vue.component('confirmation-modal', require('../components/frontend/ConfirmationModal.vue'));

const app = new Vue({
    el: '#app',

    data: {
        data: {},
        status:'',
        pagination: {
            'current_page': 1
        },
        loading: true,
        messages: '',
        user_name: ''

    },
    mounted() {
        this.fetchWishes();
        
    },

    methods: {
        fetchWishes() {
            axios.get('/wishes/getlist?page=' + this.pagination.current_page+'&status=' + this.status)
                .then(response => {
                    this.data = response.data.data.data;
                    this.pagination = response.data.pagination;
                    this.$nextTick(function () {
                        this.loading = false;
                    });

                }
            )
            .catch(error => {
                    console.log(error);
            });
        },

        formatPrice(value) {
            return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
        },

    }
});

//jquery
$(document).ready(function(){
    $('.sa-p2').css('-webkit-box-orient','vertical')
})
$('.more-details').click(function(){
    $('.sa-p2').css({'display':'block','height':'auto'})
    $(this).css('display','none')
})

$('.wm-1-btn').click(function(){
    var datas = {
        name : $('#myModal .modal-body-left .name').val(),
        nachname : $('#myModal .modal-body-left .nachname').val(),
        email : $('#myModal .modal-body-left .email').val(),
        tel : $('#myModal .modal-body-left .tel').val(),
        betreff : $('#myModal .modal-body-left .betreff').val(),
        message : $('#myModal .modal-body-bottom textarea').val()
    }
    $.ajax({
        type: "POST",
        url: "whatever.php",
        data: {datas},
        complete: function(){
            console.log(datas)
        }
    })
})

$('.wm-2-btn').click(function(){
    var datas = {
        name : $('#myModal2 .modal-body-left .name').val(),
        nachname : $('#myModal2 .modal-body-left .nachname').val(),
        email : $('#myModal2 .modal-body-left .tel').val(),
        tel : $('#myModal2 .modal-body-left #modal-select').val()
    }
    $.ajax({
        type: "POST",
        url: "method.php",
        data: {datas},
        complete: function(){
            console.log(datas)
        }
    })
})