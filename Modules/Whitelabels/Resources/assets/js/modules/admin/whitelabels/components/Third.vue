<template>
    <div class="card text-center" style="min-height: 350px;">
        <div class="card-body">
            <i class="icon-checkmark3 icon-2x text-success border-success border-3 rounded-round p-3 mb-3"></i>
            <h5 class="card-title">{{ trans('messages.created', {attribute: 'Whitelabel'})}}</h5>
            <a :href="createLink" class="btn bg-success mb-5">{{ trans('messages.whitelabel_user') }}</a>
        </div>
    </div>
</template>
<style>
    pre {
        overflow: auto;
    }
    pre .string { color: #885800; }
    pre .number { color: blue; }
    pre .boolean { color: magenta; }
    pre .null { color: red; }
    pre .key { color: green; }
</style>
<script>
  import Vuex from 'vuex'
  import { Errors } from '../../../../../../../../../resources/assets/js/utils/errors'
  export default {
    name: 'Third',
    components: { },
    data () {
      return {
        // eslint-disable-next-line
        errors: new Errors(),
        createLink: window.laroute.route('admin.access.user.create')
      }
    },
    mounted () {
    },
    watch: {
    },
    computed: {
      ...Vuex.mapGetters({
        whitelabel: 'whitelabel'
      })
    },
    methods: {
      ...Vuex.mapActions({
        addWhitelabel: 'addWhitelabel'
      }),
      prettyJSON: function (json) {
        if (json) {
          json = JSON.stringify(json, undefined, 4)
          json = json.replace(/&/g, '&').replace(/</g, '<').replace(/>/g, '>')
          // eslint-disable-next-line
          return json.replace(/("(\\u[a-zA-Z0-9]{4}|\\[^u]|[^\\"])*"(\s*:)?|\b(true|false|null)\b|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?)/g, function (match) {
            let cls = 'number'
            if (/^"/.test(match)) {
              if (/:$/.test(match)) {
                cls = 'key'
              } else {
                cls = 'string'
              }
            } else if (/true|false/.test(match)) {
              cls = 'boolean'
            } else if (/null/.test(match)) {
              cls = 'null'
            }
            return '<span class="' + cls + '">' + match + '</span>'
          })
        }
      }
    }
  }
</script>
