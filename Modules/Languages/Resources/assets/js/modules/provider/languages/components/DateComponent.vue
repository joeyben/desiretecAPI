<template>
    <div class="form-group row">
        <label class="col-lg-3 col-form-label">&nbsp;{{ trans('modals.'  + field) }} <span class="text-danger"> *</span></label>
        <div class="col-lg-9">
            <el-date-picker :start-placeholder="trans('modals.' + field)" :end-placeholder="trans('modals.' + field)" filterable size="small" style="width: 100%;" format="dd.MM.yyyy" @input="updateRoomRange"
                            :picker-options="pickerOptions"
                            range-separator="-"
                            :value="date">
            </el-date-picker>
            <div class="help-block text-danger" v-if="errors.has(field)">
                <strong v-text="errors.get(field)"></strong>
            </div>
        </div>
    </div>
</template>

<script>
  import Vuex from 'vuex'
  import moment from 'moment'
  moment.locale(window.i18.lang)

  export default {
    name: 'DateComponent',
    props: {
      errors: {
        type: Object,
        required: true
      },
      date: {
        type: String,
        required: true
      },
      field: {
        type: String,
        required: true
      }
    },
    data () {
      return {
        // eslint-disable-next-line
        pickerOptions: {
          disabledDate (time) {
            return (time.getTime() + 3600 * 1000 * 24) < Date.now()
          },
          firstDayOfWeek: 1
        }
      }
    },
    components: { },
    mounted () {
    },
    watch: {
    },
    computed: {
      ...Vuex.mapGetters({
      })
    },
    methods: {
      ...Vuex.mapActions({
      }),
      updateRoomRange (e) {
        if (e === null) return false
        this.$store.commit('updateWish', {name: this.field, value: moment(e, moment.ISO_8601).format('YYYY-MM-DD')})
      }
    }
  }
</script>
