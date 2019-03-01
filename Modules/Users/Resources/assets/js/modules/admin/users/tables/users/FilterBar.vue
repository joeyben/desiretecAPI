<template>
    <div class="card-header header-elements-inline">
        <h5 class="card-title">
            <button type="button" class="btn btn-outline bg-steel text-steel btn-icon dropdown-toggle" data-toggle="dropdown">
                <i class="icon-gear"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-left">
                <router-link class="dropdown-item" :to="{name: 'root.edit', params: { id: 0 }}" v-if="can_edit"><i class="icon-plus3"></i>{{ trans('button.create') }}</router-link>
            </div>
        </h5>
        <div class="header-elements">
            <form action="#" class="row">
                <div class="col-xl-2 col-md-12 col-sm-12">
                    <div class="form-group">
                        <el-select :value="show" placeholder="Select" multiple collapse-tags style="margin-left: 2px;"  @input="doShow">
                            <el-option style="width: 100%;"
                                       v-for="item in fields"
                                       :key="item.title"
                                       :label="item.title"
                                       :value="item.title">
                            </el-option>
                        </el-select>
                    </div>
                </div>
                <div class="col-xl-1 col-md-12 col-sm-12">
                    <div class="form-group">
                        <el-select v-model="value" placeholder="Select" @input="doPage">
                            <el-option style="width: 100%;"
                                       v-for="item in options"
                                       :key="item.value"
                                       :label="item.label"
                                       :value="item.value">
                            </el-option>
                        </el-select>
                    </div>
                </div>
                <div class="col-xl-3 col-md-12 col-sm-12">
                    <div class="form-group">
                        <el-date-picker style="width: 100%;"
                                        v-model="created"
                                        @input="doRange"
                                        type="daterange"
                                        start-placeholder="Start"
                                        end-placeholder="End">
                        </el-date-picker>
                    </div>
                </div>
                <div class="col-xl-6 col-md-12 col-sm-12">
                    <div class="form-group form-group-feedback form-group-feedback-left">
                        <div class="input-group">
                            <input type="search" class="form-control" placeholder="Search" v-model="filterText" @input="doFilter">
                            <span class="input-group-append">
                            <button type="button" class="btn btn-default heading-btn" @click="resetFilter">Reset</button>
                        </span>
                        </div>
                        <div class="form-control-feedback">
                            <i class="icon-search4 font-size-sm text-muted"></i>
                        </div>
                    </div>
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
          dialogFormVisible: false,
          form: {
            id: ''
          },
          formLabelWidth: '120px',
          created: '',
          fields: config.fields,
          filterText: '',
          whitelabel: '',
          value: 10,
          options: [{
            value: 10,
            label: '10'
          }, {
            value: 25,
            label: '25'
          }, {
            value: 50,
            label: '50'
          }, {
            value: 100,
            label: '100'
          }]
        }
      },
      computed: {
        ...Vuex.mapGetters({
          user: 'currentUser'
        }),
        createLink () {
          return window.laroute.route('admin.access.user.create')
        },
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
        },
        can_edit () {
          return this.hasPermissionTo('create-user')
        }
      },
      methods: {
        doShow (elements) {
          let filtered = elements.filter(function (el) {
            return el != null
          })
          this.fields.forEach(function (element) {
            if (filtered.indexOf(element.title) < 0) {
              if (element.visible === true) {
                element.visible = false
              }
            } else if (element.visible === false) {
              element.visible = true
            }
          })
          this.$events.fire('show-set', this.fields)
        },
        doPage () {
          this.$events.fire('page-set', this.value)
        },
        doRange (e) {
          this.$events.fire('range-date-set', moment(e[0], moment.ISO_8601).startOf('day').format('YYYY-MM-DD HH:mm:ss'), moment(e[1], moment.ISO_8601).endOf('day').format('YYYY-MM-DD  HH:mm:ss'))
        },
        doFilter () {
          if (this.filterText.length > 0) {
            this.$events.fire('filter-set', this.filterText)
          } else if (this.filterText.length === 0) {
            this.$events.fire('filter-reset')
          }
        },
        resetFilter () {
          this.filterText = ''
          this.created = ''
          this.fields = config.fields
          this.$events.fire('filter-reset')
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

