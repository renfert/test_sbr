<template>
  <div class="m-b-40">
    <data-tables
      :pagination-props="{ background: true, pageSizes: [5] }"
      :data="data"
    >
      <el-table-column
        v-for="title in titles"
        sortable="custom"
        :prop="title.prop"
        :label="title.label"
        :key="title.label"
      ></el-table-column>
    </data-tables>
  </div>
</template>

<script>
import Vue from 'vue';
import { mapState } from 'vuex';
import { DataTables, DataTablesServer } from 'vue-data-tables';
export const eventBus = new Vue();

Vue.use(DataTables);
Vue.use(DataTablesServer);
export default {
  props: ['data', 'titles'],
  data: () => {
    return {
      modal: false
    };
  },
  mounted() {},
  computed: {
    ...mapState(['lang'])
  },
  methods: {}
};
</script>
