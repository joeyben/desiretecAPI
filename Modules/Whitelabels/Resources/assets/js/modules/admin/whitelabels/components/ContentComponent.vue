<template>
    <div>
        <filter-bar :defaultWhitelabel="whitelabel.id" v-if="whitelabel.id"></filter-bar>
        <!-- Form inputs -->
        <div class="card">
            <div class="card-body">

                <legend class="text-uppercase font-size-sm font-weight-bold">
                    <i class="icon-pencil ml-2"></i>
                </legend>

                <ul class="nav nav-tabs nav-tabs-highlight">
                    <li class="nav-item" v-for="(layer, index) in layers"  v-if="layers.length > 0" @click="handleActive(layer.layer_id)">
                        <a :href="'#' + layer.name " class="nav-link" v-bind:class="{'active': index === 0}" data-toggle="tab">
                            {{ layer.name }}
                        </a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane fade" v-if="layers[0]" v-for="(layer, index) in layers" :class="{'active show': isTab === layer.layer_id}" :id="'#' + layer.name">
                        <layer-content :layer="layer" :key="layer.id"></layer-content>
                    </div>
                </div>
            </div>
        </div>
        <!-- /form inputs -->
    </div>
</template>

<script>
  import Vuex from 'vuex'
  import { Errors } from '../../../../../../../../../resources/assets/js/utils/errors'
  import UploadAttachments from '../../../../../../../../../resources/assets/js/utils/UploadAttachments'
  import FilterBar from './FilterBar'
  import LayerContent from './LayerContent'
  export default {
    name: 'ContentComponent',
    components: { FilterBar, LayerContent, UploadAttachments },
    data () {
      return {
        // eslint-disable-next-line
        errors: new Errors(),
        isTab: 1,
        layers: [],
        contents: window.contents,
        radio1: null,
        dialogFormVisible: false,
        form: {
          id: ''
        }
      }
    },
    computed: {
      ...Vuex.mapGetters({
        whitelabel: 'whitelabel',
        whitelabels: 'whitelabels',
        user: 'currentUser'
      })
    },
    mounted () {
      this.loadUser()
      this.loadWhitelabels()
      this.loadCurrentWhitelabel()
      this.$events.$on('whitelabel-set', (id) => this.doWhitelabel(id))
    },
    methods: {
      ...Vuex.mapActions({
        loadUser: 'loadLoggedUser',
        loadWhitelabel: 'loadWhitelabel',
        loadWhitelabels: 'loadWhitelabels',
        loadCurrentWhitelabel: 'loadCurrentWhitelabel'
      }),
      handleActive (tab) {
        this.isTab = tab
      },
      updateWhitelabel (e) {
        if (e.target.value !== null) {
          var tabnr = parseInt($('.tab-content .active').data('tabnr') - 1)
          this.$store.commit('updateWhitelabel', {name: e.target.name, value: e.target.value, tabnr: tabnr})
        }
      },
      doWhitelabel (id) {
        this.loadWhitelabel(id)
      },
      doSeleted (value) {
        this.$store.commit('updateWhitelabel', {name: 'content', value: value})
        if (this.hasRole('Administrator')) {
          this.dialogFormVisible = true
        } else {
          this.onSubmit()
        }
      },
      onCreate () {
        this.dialogFormVisible = false
        this.onSubmit()
      },
      onSubmit () {
        this.$store.dispatch('block', {element: 'contentComponent', load: true})
        this.$http.put(window.laroute.route('admin.whitelabels.content.update'), this.whitelabel)
          .then(this.onSubmitStore)
          .catch(this.onFailed)
          .then(() => {
            this.$store.dispatch('block', {element: 'contentComponent', load: false})
          })
      },
      onSubmitSuccess (response) {
        if (response.data.hasOwnProperty('success') && response.data.success === true) {
          this.$message({
            message: response.data.message,
            showClose: true,
            type: 'success'
          })
        } else {
          this.$message({
            message: response.data.message,
            showClose: true,
            type: 'error'
          })
        }
      },
      hasRole (role) {
        return this.user.hasOwnProperty('roles') && this.user.roles[role]
      },
      hasPermissionTo (permission) {
        return this.user.hasOwnProperty('permissions') && this.user.permissions[permission]
      }
    },
    created () {
      this.$store.dispatch('block', {element: 'contentComponent', load: true})
      this.$http.get(window.laroute.route('admin.whitelabels.content.view'))
        .then((response) => {
          this.layers = response.data.data
        })
        .catch(this.onFailed)
        .then(() => {
          this.$store.dispatch('block', {element: 'contentComponent', load: false})
        })
    }
  }
</script>

<style scoped>
    .time {
        font-size: 13px;
        color: #999;
    }

    .bottom {
        margin-top: 13px;
        line-height: 12px;
    }

    .button {
        padding: 0;
        float: right;
    }

    .image {
        width: 100%;
        display: block;
    }

    .clearfix:before,
    .clearfix:after {
        display: table;
        content: "";
    }

    .clearfix:after {
        clear: both
    }
</style>
