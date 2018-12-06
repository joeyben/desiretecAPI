<template>
    <div>
        <el-table :data="options" style="width: 100%" stripe :empty-text="trans('tables.empty_table')" height="400">
            <el-table-column type="expand">
                <template slot-scope="props">
                    <p v-for="(value, key) in props.row.properties">{{ trans('tables.' + key) }} : <span v-html="value"></span></p>
                </template>
            </el-table-column>
            <el-table-column :label="trans('tables.date')" prop="created_at" sortable>
            </el-table-column>
            <el-table-column :label="trans('tables.name')" prop="causer">
            </el-table-column>
            <el-table-column :label="trans('tables.activity')" prop="description">
            </el-table-column>
        </el-table>
    </div>
</template>

<script>
  export default {
    name: 'VueTable',
    props: {
      options: Array
    }
  }
</script>
