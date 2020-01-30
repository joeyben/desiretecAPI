<template>
    <div>
        <filter-bar :defaultWhitelabel="whitelabel.id" v-if="whitelabel.id"></filter-bar>

        <form action="#">
            <div class="card">
                <div class="card-header">
                    Layer auswählen
                </div>

                <div class="card-body">
                    <div class="row">
                        <el-col v-for="(layer, index) in layers" :key="layer.id" class="col-xl-4 col-sm-6">
                            <el-card :body-style="{ padding: '0px' }" shadow="hover">
                                <img :src="layer.url" class="image">
                                <div style="padding: 14px;">
                                    <span v-text="layer.description"></span>
                                    <div class="bottom clearfix">
                                        <el-checkbox
                                                :name="layer.name"
                                                :label="layer.id"
                                                class="whitelabel_layer_selecter"
                                                v-model="checked"
                                                border
                                                @input="doSeleted(layer.id)">
                                            {{ layer.name }}
                                        </el-checkbox>

                                        <el-input
                                                placeholder="Please input"
                                                class="float-left hide"
                                                :name="layer.name"
                                                :value="layer.url"
                                                @input="doUrlSelect(layer)"
                                                clearable>
                                        </el-input>
                                    </div>
                                </div>
                            </el-card>
                        </el-col>
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
  export default {
    name: 'LayersComponent',
    components: { FilterBar },
    data () {
      return {
        layers: window.layers,
        checked: null,
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
        this.$store.dispatch('block', {element: 'layersComponent', load: true})
        this.$http.put(window.laroute.route('admin.whitelabels.layers.update'), {layer: this.whitelabel.layer, whitelabel_id: this.form.id})
          .then(this.onSubmitStore)
          .catch(this.onFailed)
          .then(() => {
            this.$store.dispatch('block', {element: 'layersComponent', load: false})
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
