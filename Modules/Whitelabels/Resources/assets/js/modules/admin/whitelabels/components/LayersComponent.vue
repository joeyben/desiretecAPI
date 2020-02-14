<template>
    <div>
        <filter-bar :defaultWhitelabel="whitelabel.id" v-if="whitelabel.id"></filter-bar>

        <form action="#" @submit.prevent="onSubmit" @keydown="errors.clear($event.target.name)">
            <div class="card">
                <div class="card-header">
                    Layer auswählen
                </div>

                <div class="card-body">
                    <div class="row">
                        <el-checkbox-group v-model="checkedLayers" :max="max">
                            <el-col v-for="(layer, index) in layers" :key="layer.id" class="col-xl-3 col-sm-6">
                            <el-card :body-style="{ padding: '0px' }" shadow="hover">
                                <img :src="layer.image" class="image">
                                <div style="padding: 14px;">
                                    <span v-text="layer.description"></span>
                                    <div class="bottom clearfix">
                                        <el-checkbox :label="layer.id" :key="layer.id">{{layer.name}}</el-checkbox>

                                        <el-input
                                                placeholder="Please input"
                                                type="url"
                                                class="float-left hide"
                                                :name="pivot[layer.id]"
                                                v-model="pivot[layer.id]"
                                                :disabled="isIncludes(layer.id)"
                                                clearable>
                                        </el-input>
                                    </div>
                                </div>
                            </el-card>
                        </el-col>

                        </el-checkbox-group>
                    </div>
                </div>

                <div class="card-footer">
                    <div class="text-left">
                        <button class="btn btn-primary">Speichern</button>
                    </div>
                </div>
            </div>

        </form>

    </div>
</template>

<script>
  import Vuex from 'vuex'
  import FilterBar from './FilterBar'
  import { Errors } from '../../../../../../../../../resources/assets/js/utils/errors'
  export default {
    name: 'LayersComponent',
    components: { FilterBar },
    data () {
      return {
        // eslint-disable-next-line
        errors: new Errors(),
        checkedLayers: [],
        pivot: [],
        max: 1,
        whitelabel: {},
        layers: [],
        checked: null,
        dialogFormVisible: false,
        form: {
          id: ''
        }
      }
    },
    computed: {
      ...Vuex.mapGetters({
        whitelabels: 'whitelabels',
        user: 'currentUser'
      })
    },
    mounted () {
      this.loadUser()
      this.loadWhitelabels()
      this.$events.$on('whitelabel-set', (id) => this.doWhitelabel(id))
    },
    methods: {
      ...Vuex.mapActions({
        loadUser: 'loadLoggedUser',
        loadWhitelabel: 'loadWhitelabel',
        loadWhitelabels: 'loadWhitelabels',
        loadCurrentWhitelabel: 'loadCurrentWhitelabel'
      }),
      doLayerSelect (id) {
        debugger
      },
      isIncludes (id) {
        if (!this.checkedLayers.includes(id)) {
          this.pivot[id] = ''
        }

        return !this.checkedLayers.includes(id)
      },
      doWhitelabel (id) {
        this.loadWhitelabel(id)
      },
      doUrlSelect (layer) {
        this.$store.commit('updateWhitelabelUrl', {name: layer.name, value: layer.url})
      },
      doSeleted (value) {
        this.$store.commit('updateWhitelabel', {name: 'layer', value: value})
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
        let check = true
        this.checkedLayers.forEach((layer) => {
          if (this.pivot[layer] === '') {
            this.$message({
              message: 'Error',
              showClose: true,
              type: 'error'
            })

            check = false
          }
        })
        if (check) {
          this.$store.dispatch('block', {element: 'layersComponent', load: true})
          this.$http.put(window.laroute.route('admin.whitelabels.layers.update'), {layers: this.checkedLayers, pivot: this.pivot})
            .then(this.onSubmitSuccess)
            .catch(this.onFailed)
            .then(() => {
              this.$store.dispatch('block', {element: 'layersComponent', load: false})
            })
        }
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
      },
      generateLayers (layers) {
        let data = []
        let pivot = []
        layers.forEach((layer, index) => {
          data.push(layer['id'])
          pivot[layer['id']] = layer['pivot'].layer_url
        })
        this.checkedLayers = data
        this.pivot = pivot
      },
      onFailed (error) {
        if (error.response !== undefined && error.response.hasOwnProperty('data') && error.response.data.hasOwnProperty('errors')) {
          this.errors.record(error.response.data.errors)
          if (error.response.data.hasOwnProperty('success') && error.response.data.hasOwnProperty('message')) {
            this.$notify.error({ title: 'Failed', message: error.response.data.message })
          } else {
            this.$notify.error({ title: 'Failed', dangerouslyUseHTMLString: true, message: this.errors.getErrors(this.errors.errors) })
          }
        } else if (error.response !== undefined && error.response.hasOwnProperty('data') && error.response.data.hasOwnProperty('message')) {
          this.$notify.error({ title: 'Failed', message: error.response.data.message })
        } else if (error.hasOwnProperty('message')) {
          this.$notify.error({ title: 'Error', message: error.message })
        } else {
          this.$notify.error({ title: 'Failed', message: 'Service not answer, Please contact your Support' })
          console.log(error)
        }
      }
    },
    created () {
      this.$store.dispatch('block', {element: 'layersComponent', load: true})
      this.$http.get(window.laroute.route('admin.whitelabels.layers.view'))
        .then((response) => {
          this.layers = response.data.layers
        })
        .catch(this.onFailed)
        .then(() => {
          this.$store.dispatch('block', {element: 'layersComponent', load: false})
        })

      this.$http.get(window.laroute.route('admin.whitelabels.current'))
        .then((response) => {
            this.whitelabel = response.data.whitelabel
            this.generateLayers(this.whitelabel.layers)
            if (this.whitelabel.licence !== 0) {
              this.max = 4
            }
        })
        .catch(this.onFailed)
        .then(() => {
          this.$store.dispatch('block', {element: 'layersComponent', load: false})
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
