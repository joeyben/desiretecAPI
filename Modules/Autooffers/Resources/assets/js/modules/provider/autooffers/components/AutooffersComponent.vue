<template>
    <!-- Form inputs -->
    <div class="card">
        <div class="card-body">
            <form action="#" @submit.prevent="onSubmit" @keydown="errors.clear($event.target.name)">
                <fieldset class="mb-3">
                    <legend class="text-uppercase font-size-sm font-weight-bold">Auto offer management</legend>

                    <div class="form-group row" v-if="hasRole('Administrator')">
                        <label class="col-form-label col-lg-2">{{ trans('modals.whitelabel') }}</label>
                        <div class="col-lg-10">
                            <el-select :value="autooffer.whitelabel_id" placeholder="Please choose a Whitelabel" style="width: 100%;" @input="updateWhitelabel">
                                <el-option
                                        v-for="item in whitelabels"
                                        :key="item.id"
                                        :label="item.name"
                                        :value="item.id">
                                    <span style="float: left"><i :class="item.name"></i> {{ item.name }}</span>
                                </el-option>
                            </el-select>
                        </div>
                    </div>

                    <div class="form-group row" v-if="autooffer.id !== 0">
                        <label class="col-form-label col-lg-2">{{ trans('modals.whitelabel') }}</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control disabled" disabled readonly id='id' name='id' :placeholder="trans('modals.id')" :value="autooffer.id"/>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-lg-2">{{ trans('modals.display_offer') }}</label>
                        <div class="col-lg-10">
                            <el-slider
                                    :value="autooffer.display_offer"
                                    :step="1"
                                    :max="10"
                                    show-stops
                                    show-input
                                    @input="updateAutoofferDisplayed">
                            </el-slider>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-2">{{ trans('modals.recommendation') }}</label>
                        <div class="col-lg-10">
                            <el-slider
                                    :value="autooffer.recommendation"
                                    :step="1"
                                    show-input
                                    @input="updateAutoofferRecommendation">
                            </el-slider>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-lg-2">{{ trans('modals.rating') }}</label>
                        <div class="col-lg-10">
                            <el-slider :value="autooffer.rating"  :max="10" :step="0.1" show-input @input="updateAutoofferRating"></el-slider>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-lg-2">{{ trans('modals.status') }}</label>
                        <div class="col-lg-10">
                            <el-switch
                                    @input="updateStatus"
                                    :value="autooffer.status"
                                    active-color="#13ce66"
                                    inactive-color="#ff4949">
                            </el-switch>
                        </div>
                    </div>
                </fieldset>

                <div class="text-right">
                    <button type="submit" class="btn btn-primary">{{ trans('button.save') }}<i class="icon-paperplane ml-2"></i></button>
                </div>
            </form>
        </div>
    </div>
    <!-- /form inputs -->
</template>

<script>
  import Vuex from 'vuex'
  export default {
    name: 'AutooffersComponent',
    components: { },
    data () {
      return {
        value2: 0,
        value3: 0,
        value4: 0,
        form: {
          id: ''
        }
      }
    },
    mounted () {
      this.loadUser()
      this.loadAutoSetting(0)
    },
    watch: {
    },
    computed: {
      ...Vuex.mapGetters({
        user: 'currentUser',
        autooffer: 'autooffer',
        whitelabels: 'whitelabels'
      })
    },
    methods: {
      ...Vuex.mapActions({
        loadUser: 'loadLoggedUser',
        addAutooffer: 'addAutooffer',
        loadAutoSetting: 'loadAutoSetting'
      }),
      updateStatus (value) {
        this.$store.commit('updateAutooffer', {name: 'status', value: value})
      },
      updateAutoofferDisplayed (value) {
        this.$store.commit('updateAutooffer', {name: 'display_offer', value: value})
      },
      updateAutoofferRating (value) {
        this.$store.commit('updateAutooffer', {name: 'rating', value: value})
      },
      updateAutoofferRecommendation (value) {
        this.$store.commit('updateAutooffer', {name: 'recommendation', value: value})
      },
      updateWhitelabel (value) {
        this.loadAutoSetting(value)
      },
      onSubmit () {
        if (this.autooffer.id === 0) {
          this.onSubmitStore()
        } else {
          this.onSubmitUpdate(this.autooffer.id)
        }
      },
      onSubmitStore () {
        this.$store.dispatch('block', {element: 'autooffersComponent', load: true})
        this.$http.put(window.laroute.route('admin.autooffers.store'), this.autooffer)
          .then(this.onSubmitSuccess)
          .catch(this.onFailed)
          .then(() => {
            this.$store.dispatch('block', {element: 'autooffersComponent', load: false})
          })
      },
      onSubmitUpdate (id) {
        this.$store.dispatch('block', {element: 'autooffersComponent', load: true})
        this.$http.put(window.laroute.route('admin.autooffers.update', {id: id}), this.autooffer)
          .then(this.onSubmitSuccess)
          .catch(this.onFailed)
          .then(() => {
            this.$store.dispatch('block', {element: 'autooffersComponent', load: false})
          })
      },
      onSubmitSuccess (response) {
        if (response.data.hasOwnProperty('success') && response.data.success === true) {
          debugger
          this.addAutooffer(response.data.autooffer)
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
      }
    }
  }
</script>
