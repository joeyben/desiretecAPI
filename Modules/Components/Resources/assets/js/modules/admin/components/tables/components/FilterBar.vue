<template>
    <div class="card-header header-elements-inline">
        <div class="header-elements">
            <form action="#" class="row">
                <div class="col-xl-7 col-md-12 col-sm-12">
                    <div class="form-group">
                        <el-select :value="show" placeholder="Select" multiple collapse-tags style="margin-left: 2px;width: 100%;"  @input="doShow">
                            <el-option
                                    v-for="item in fields"
                                    :key="item.title"
                                    :label="item.title"
                                    :value="item.title">
                            </el-option>
                        </el-select>
                    </div>
                </div>
                <div class="col-xl-5 col-md-12 col-sm-12">
                    <div class="form-group">
                        <el-select v-model="value" placeholder="Select" @input="doPage" style="width: 100%;">
                            <el-option
                                    v-for="item in options"
                                    :key="item.value"
                                    :label="item.label"
                                    :value="item.value">
                            </el-option>
                        </el-select>
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
          return this.user.hasOwnProperty('roles') && this.user.permissions[role]
        }
      }
    }
</script>

