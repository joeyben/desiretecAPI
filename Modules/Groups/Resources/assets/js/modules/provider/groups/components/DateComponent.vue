<template>
    <div class="form-group row">
        <label class="col-lg-3 col-form-label">&nbsp;{{ trans('modals.deactivation_duration') }} <span class="text-danger"> *</span></label>
        <div class="col-lg-9">
            <el-date-picker
                    filterable
                    :start-placeholder="trans('modals.from')"
                    :end-placeholder="trans('modals.until')"
                    :picker-options="pickerOptions"
                    format="dd.MM.yyyy"
                    style="width: 100%;"
                    @input="updateActivateAt"
                    :value="range"
                    type="daterange"
                    range-separator="-">
            </el-date-picker>
            <div class="help-block text-danger" v-if="errors.has('deactivate_at')">
                <strong v-text="errors.get('deactivate_at')"></strong>
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
      start: {
      },
      end: {
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
      }),
      range () {
        return this.start === null ? null : [this.start_date, this.end_date]
      },
      start_date () {
        return this.start === null ? new Date() : this.start
      },
      end_date () {
        return this.end === null ? new Date() : this.end
      }
    },
    methods: {
      ...Vuex.mapActions({
      }),
      updateActivateAt (e) {
        if (e === null) {
          this.$store.commit('updateGroup', {name: 'deactivate_at', value: null})
          this.$store.commit('updateGroup', {name: 'deactivate_until', value: null})
        } else {
          this.$store.commit('updateGroup', {name: 'deactivate_at', value: moment(e[0], moment.ISO_8601).format('YYYY-MM-DD')})
          this.$store.commit('updateGroup', {name: 'deactivate_until', value: moment(e[1], moment.ISO_8601).format('YYYY-MM-DD')})
        }
      }
    }
  }
</script>
