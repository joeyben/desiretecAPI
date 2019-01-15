
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
        // this.fetchMessages();

        // Echo.private('chat')
        //     .listen('MessageSentEvent',  (e) => {
        //         this.messages.push({
        //             message: e.message.message,
        //             user: e.user
        //         })
        //     })
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