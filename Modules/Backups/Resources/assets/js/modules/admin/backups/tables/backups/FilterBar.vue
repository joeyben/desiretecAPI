<template>
    <div class="card-header header-elements-inline">
        <h5 class="card-title">
            <a href="javascript:;" class="btn alpha-teal text-teal-800 btn-icon rounded-round ml-2" @click="createBackup()"><i class="icon-plus3"></i></a>
        </h5>
        <div class="header-elements">
            <form action="#" class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <el-select :value="show" placeholder="Select" multiple collapse-tags style="margin-left: 2px;"  @input="doShow">
                            <el-option
                                    v-for="item in fields"
                                    :key="item.title"
                                    :label="item.title"
                                    :value="item.title">
                            </el-option>
                        </el-select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <el-select v-model="value" placeholder="Select" @input="doPage">
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
    import config from './config'
    export default {
      name: 'FilterBar',
      data () {
        return {
          fields: config.fields,
          filterText: '',
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
        createBackup () {
          this.$events.fire('create-backup')
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
        }
      }
    }
</script>

