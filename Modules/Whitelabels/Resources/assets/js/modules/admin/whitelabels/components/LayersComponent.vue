<template>
    <div>
        <filter-bar :defaultWhitelabel="whitelabel.id" v-if="whitelabel.id"></filter-bar>
        <div class="row">
            <el-col v-for="(layer, index) in layers" :key="layer.id"  class="col-xl-4 col-sm-6">
                <el-card :body-style="{ padding: '0px' }" shadow="hover">
                    <img :src="layer.url" class="image">
                    <div style="padding: 14px;">
                        <span v-text="layer.description"></span>
                        <div class="bottom clearfix">
                            <div class="row">
                                <el-checkbox :id="layer.id" v-model="checked[layer.name]" :value="layer.name" :label="layer.id" border>{{ layer.name }}</el-checkbox>
                                <el-input :id="layer.id" v-if="checked[layer.name]" style="width: 65%; padding-left:10px" placeholder="Please enter URL"></el-input>
                            </div>
                        </div>
                    </div>
                </el-card>
            </el-col>
        </div>
        <div class="row row-footer">
            <div style="margin-top: 15px;">
                <button class="btn btn-outline bg-teal-600 text-teal-600 border-teal-600 btn-sm ">{{ trans('button.confirm') }}</button>
            </div>
        </div>
        <el-dialog title="Please choose a Whitelabel" :visible.sync="dialogFormVisible" width="35%">
            <el-form :model="form">
                <el-form-item :label="trans('modals.whitelabel')">
                    <el-select v-model="form.id" placeholder="Please choose a Whitelabel" style="width: 100%;">
                        <el-option
                                v-for="item in whitelabels"
                                :key="item.id"
                                :label="item.name"
                                :value="item.id">
                            <span style="float: left"><i :class="item.name"></i> {{ item.name }}</span>
                        </el-option>
                    </el-select>
                </el-form-item>
            </el-form>n
            <span slot="footer" class="dialog-footer">
                <button class="btn btn-outline-danger btn-sm" @click="dialogFormVisible = false"><i class="icon-cancel-circle2 mr-1"></i> {{ trans('button.cancel') }}</button>
                <button class="btn btn-outline bg-teal-600 text-teal-600 border-teal-600 btn-sm" @click="onCreate()" v-if="form.id !== ''"> {{ trans('button.confirm') }}</button>
            </span>
        </el-dialog>
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
        dialogFormVisible: false,
        checked: [],
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
      doSeleted (value) {
        if (value) {
          console.log(name)
          this.urlInputVisible = true
        } else {
          this.urlInputVisible = false
        }
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

    .row-footer {
        justify-content: flex-end;
        padding: 0 15px;
    }
</style>