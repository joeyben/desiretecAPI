<template>
    <div class="card-header header-elements-inline">
        <h5 class="card-title">
            <button type="button" class="btn btn-outline bg-teal-300 text-teal-800 btn-icon dropdown-toggle" data-toggle="dropdown">
                <i class="icon-gear"></i>
            </button>

            <div class="dropdown-menu dropdown-menu-left">
                <a href="#" class="dropdown-item disabled"><i class="icon-file-text3"></i> Export Selected</a>
                <a href="#" class="dropdown-item disabled"><i class="icon-file-text3"></i> Export All</a>
            </div>
        </h5>
        <div class="header-elements">
            <form action="#">
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
</template>

<script>
    import Vuex from 'vuex'
    import config from './config'
    import moment from 'moment'
    moment.locale(window.i18.lang)
    export default {
      name: 'FilterBar',
      data () {
        return {
          fields: config.fields,
          whitelabel: ''
        }
      },
      computed: {
        ...Vuex.mapGetters({
          whitelabels: 'whitelabels',
          user: 'currentUser'
        }),
        show () {
          let results = []
          if (this.fields.length > 0) {
            this.fields.forEach(function (element) {
              if (element.visible) {
                results.push(element.title)
              }
            })
          }

          return results
        }
      },
      methods: {
        doWhitelabel () {
          this.$events.fire('whitelabel-set', this.whitelabel)
        },
        hasRole (role) {
          return this.user.hasOwnProperty('roles') && this.user.roles[role]
        }
      }
    }
</script>

