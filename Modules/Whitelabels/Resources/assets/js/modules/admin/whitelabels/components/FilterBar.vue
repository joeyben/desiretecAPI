<template>
    <!-- Filter toolbar -->
    <div class="navbar navbar-expand-lg navbar-light navbar-component rounded" v-if="hasRole('Administrator')">
        <div class="text-center d-lg-none w-100">
            <button type="button" class="navbar-toggler dropdown-toggle" data-toggle="collapse" data-target="#navbar-filter">
                <i class="icon-unfold mr-2"></i>
                Filters
            </button>
        </div>

        <div class="navbar-collapse collapse" id="navbar-filter">
                <span class="navbar-text font-weight-semibold mr-3">
                    Filter:
                </span>
            <div class="header-elements">
                <form action="#" class="row">
                    <div class="form-group" v-if="hasRole('Administrator')">
                        <el-select v-model="whitelabel" :placeholder="trans('tables.whitelabel')" @input="doWhitelabel">
                            <el-option style="width: 100%;"
                                       v-for="item in whitelabels"
                                       :key="item.id"
                                       :label="item.name"
                                       :value="item.id">
                            </el-option>
                        </el-select>
                    </div>
                </form>
            </div>

        </div>
    </div>
    <!-- /filter toolbar -->
</template>

<script>
  import Vuex from 'vuex'
  export default {
    name: 'FilterBar',
    data () {
      return {
        whitelabel: ''
      }
    },
    props: {
      defaultWhitelabel: {
        default: ''
      }
    },
    computed: {
      ...Vuex.mapGetters({
        whitelabels: 'whitelabels',
        user: 'currentUser'
      })
    },
    mounted () {
      this.whitelabel = this.defaultWhitelabel
    },
    methods: {
      ...Vuex.mapActions({
      }),
      doWhitelabel () {
        this.$events.fire('whitelabel-set', this.whitelabel)
      },
      hasRole (role) {
        return this.user.hasOwnProperty('roles') && this.user.roles[role]
      }
    }
  }
</script>

<style scoped>

</style>
