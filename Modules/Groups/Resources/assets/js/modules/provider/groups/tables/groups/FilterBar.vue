<template>
    <div class="card-header header-elements-inline">
        <h5 class="card-title">
            <button type="button" class="btn btn-outline bg-teal-300 text-teal-800 btn-icon dropdown-toggle" data-toggle="dropdown">
                <i class="icon-gear"></i>
            </button>

            <div class="dropdown-menu dropdown-menu-left">
                <router-link class="dropdown-item" :to="{name: 'root.edit', params: { id: 0 }}" v-if="hasPermissionTo('create-group') && !hasRole('Administrator')"><i class="icon-plus3"></i>{{ trans('button.create') }}</router-link>
                <a href="javascript:;" class="dropdown-item" v-on:click="dialogFormVisible = true" v-if="hasRole('Administrator')"><i class="icon-plus3"></i>  {{ trans('button.create') }}</a>
                <a href="javascript:;" v-on:click="onExportSelected()" class="dropdown-item"><i class="icon-file-text3"></i> Export Selected</a>
                <a :href="urlExport" class="dropdown-item"><i class="icon-file-text3"></i> Export All</a>
            </div>
        </h5>
        <div class="header-elements">
            <form action="#" class="row">
                <div class="col-xl-2 col-md-12 col-sm-12">
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
                </div>
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
                <div class="col-xl-4 col-md-12 col-sm-12">
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
            </el-form>
            <span slot="footer" class="dialog-footer">
                <button class="btn btn-outline-danger btn-sm" @click="dialogFormVisible = false"><i class="icon-cancel-circle2 mr-1"></i> {{ trans('button.cancel') }}</button>
                <button class="btn btn-outline bg-teal-600 text-teal-600 border-teal-600 btn-sm" @click="onCreate()" v-if="form.id !== ''"> {{ trans('button.confirm') }}</button>
            </span>
        </el-dialog>
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
          urlExport: window.laroute.route('admin.groups.export'),
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
          whitelabels: 'whitelabels',
          checked: 'checked',
          user: 'currentUser'
        }),
        urlExportSelected () {
          return window.laroute.route('admin.groups.export', {checked: this.checked})
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
        }
      },
      methods: {
        onExportSelected () {
          if (this.checked.length <= 0) {
            this.$message({
              message: 'Please select at least one item',
              showClose: true,
              type: 'error'
            })

            return false
          }

          window.location.href = this.urlExportSelected
        },
        onCreate () {
          this.dialogFormVisible = false
          this.$router.push({name: 'root.create', params: { id: 0, whitelabel_id: this.form.id }})
        },
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
        doWhitelabel () {
          this.$events.fire('whitelabel-set', this.whitelabel)
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
          this.whitelabel = ''
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

