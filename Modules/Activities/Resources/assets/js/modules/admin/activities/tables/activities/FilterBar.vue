<template>
    <div class="card-header header-elements-inline">
        <h5 class="card-title">
            <router-link class="btn alpha-teal text-teal-800 btn-icon rounded-round ml-2" :to="{name: 'root.edit', params: { id: 0 }}"><i class="icon-plus3"></i></router-link>
        </h5>
        <div class="header-elements">
            <form action="#">
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
            </form>
        </div>
    </div>
</template>

<script>
  export default {
    name: 'FilterBar',
    data () {
      return {
        filterText: ''
      }
    },
    methods: {
      doFilter () {
        if (this.filterText.length > 0) {
          this.$events.fire('filter-set', this.filterText)
        } else if (this.filterText.length === 0) {
          this.resetFilter()
        }
      },
      resetFilter () {
        this.filterText = ''
        this.$events.fire('filter-reset')
      }
    }
  }
</script>
