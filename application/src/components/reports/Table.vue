<template>
  <div class="m-b-40">
    <div style="margin-bottom: 10px">
      <el-row class="m-b-40">
        <el-col :sm="6" :xs="16">
          <el-input v-model="filters[0].value" placeholder="Search"></el-input>
        </el-col>
        <el-col v-if="data != null" :span="6">
          <export-excel :data="data" name="exams.xls">
            <el-tooltip
              class="item"
              effect="dark"
              :content="lang['export']"
              placement="top"
            >
              <el-button
                class="sbr-purple ml-3"
                type="primary"
                icon="el-icon-download"
                circle
              ></el-button>
            </el-tooltip>
          </export-excel>
        </el-col>
      </el-row>
    </div>
    <data-tables
      :filters="filters"
      :table-props="tableProps"
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
import excel from 'vue-excel-export';

import { mapState } from 'vuex';
import { DataTables, DataTablesServer } from 'vue-data-tables';
export const eventBus = new Vue();

Vue.use(excel);
Vue.use(DataTables);
Vue.use(DataTablesServer);
export default {
  props: ['data'],
  data: () => {
    return {
      modal: false,
      filters: [
        { prop: 'student', value: '' },
        { prop: 'course', value: '' },
        { prop: 'examTitle', value: '' },
        { prop: 'status', value: '' }
      ],
      titles: [
        { prop: 'group', label: 'Group' },
        { prop: 'course', label: 'Course' },
        { prop: 'examTitle', label: 'Exam' },
        { prop: 'examApproval', label: 'Approval(%)' },
        { prop: 'student', label: 'Student' },
        { prop: 'studentScore', label: 'Score' },
        { prop: 'status', label: 'Status' },
        { prop: 'studentRetest', label: 'Tentativas' }
      ],
      tableProps: { defaultSort: { prop: 'course', order: 'descending' } }
    };
  },
  mounted() {
    this.titles[0].label = this.lang.group;
    this.titles[1].label = this.lang.course;
    this.titles[2].label = this.lang.exam;
    this.titles[3].label = this.lang['minimum-for-approval'] + '(%)';
    this.titles[4].label = this.lang.student;
    this.titles[5].label = this.lang.score + '(%)';
    this.titles[6].label = this.lang.status;
    this.titles[7].label = this.lang.attempts;
  },
  computed: {
    ...mapState(['lang'])
  }
};
</script>
