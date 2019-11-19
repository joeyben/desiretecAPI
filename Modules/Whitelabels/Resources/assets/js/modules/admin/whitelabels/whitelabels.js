import Vue from 'vue'
import VueRouter from 'vue-router'
import store from '../../../vuex/store'
import Lang from '../../../../../../../../resources/assets/js/utils/lang'
import ElementUI from 'element-ui'
import 'element-ui/lib/theme-chalk/index.css'
import de from 'element-ui/lib/locale/lang/de'
import en from 'element-ui/lib/locale/lang/en'
import fr from 'element-ui/lib/locale/lang/fr'
import locale from 'element-ui/lib/locale'
import VueEvents from 'vue-events'
require('../../../bootstrap')
Vue.use(VueEvents)
Vue.use(VueRouter)
Vue.use(ElementUI, { locale })

if (window.i18.lang === 'de') {
  locale.use(de)
} else if (window.i18.lang === 'en') {
  locale.use(en)
} else {
  locale.use(fr)
}

Vue.prototype.$http = window.axios
Vue.prototype.trans = (key, options = {}) => {
  // eslint-disable-next-line
    Lang.setLocale(window.i18.lang)
  return Lang.get(key, options)
}

Vue.filter('str_limit', function (string, value) {
  return string.length <= parseInt(value) ? string : string.substring(0, value) + ' ...'
})

let $whitelabelsComponent = document.querySelector('#whitelabelsComponent')
let $layersComponent = document.querySelector('#layersComponent')
let $contentComponent = document.querySelector('#contentComponent')
let $whitelabelsProviderComponent = document.querySelector('#whitelabelsProviderComponent')

if ($whitelabelsProviderComponent) {
  const router = new VueRouter({
    routes: [{
      path: '/',
      name: 'root',
      component: require('./components/WhitelabelsProviderComponent.vue')
    }]
  })

  new Vue({
    el: '#whitelabelsProviderComponent',
    router,
    store,
    components: { },
    mounted () {
    },
    methods: {
    }
  })
}

if ($layersComponent) {
  const router = new VueRouter({
    routes: [{
      path: '/',
      name: 'root',
      component: require('./components/LayersComponent.vue')
    }]
  })

  new Vue({
    el: '#layersComponent',
    router,
    store,
    components: { },
    mounted () {
    },
    methods: {
    }
  })
}

if ($contentComponent) {
  const router = new VueRouter({
    routes: [{
      path: '/',
      name: 'root',
      component: require('./components/ContentComponent.vue')
    }]
  })

  new Vue({
    el: '#contentComponent',
    router,
    store,
    components: { },
    mounted () {
    },
    methods: {
    }
  })
}

if ($whitelabelsComponent) {
  const router = new VueRouter({
    routes: [{
      path: '/',
      name: 'root',
      component: require('./components/WhitelabelsComponent.vue'),
      children: [{
        path: '/edit/:id(\\d+)',
        name: 'root.edit',
        component: require('./components/EditWhitelabelComponent.vue')
      }]
    }, {
      path: '/create',
      name: 'root.create',
      component: require('./components/CreateWhitelabelComponent.vue'),
      children: [{
        path: '/first',
        name: 'create.first',
        component: require('./components/First.vue')
      }, {
        path: '/second',
        name: 'create.second',
        component: require('./components/Second.vue')
      }, {
        path: '/third',
        name: 'create.third',
        component: require('./components/Third.vue')
      }]
    }
    ]
  })
  new Vue({
    el: '#whitelabelsComponent',
    router,
    store,
    components: { },
    mounted () {
    },
    methods: {
    }
  })
}
