<template>
  <div class="card-box table-responsive" v-if="recordList != null">
    <div>
      <el-row>
        <el-col :md="6" :xs="24">
          <el-input v-model="filters[0].value" placeholder="Search"></el-input>
        </el-col>
      </el-row>
    </div>
    <data-tables
      :pagination-props="{ background: true, pageSizes: [5] }"
      :data="recordList"
      :filters="filters"
    >
      <el-table-column
        v-for="title in titles"
        sortable="custom"
        :prop="title.prop"
        :label="title.label"
        :key="title.label"
      ></el-table-column>
      <el-table-column label="Progress" align="center">
        <template slot-scope="scope">{{
          parseInt((100 * scope.row.finishedLessons) / scope.row.lessons)
        }}</template>
      </el-table-column>
      <el-table-column label="Status" align="center">
        <template slot-scope="scope">
          <p
            v-if="
              parseInt((100 * scope.row.finishedLessons) / scope.row.lessons) >
                0 &&
              parseInt((100 * scope.row.finishedLessons) / scope.row.lessons) <
                100
            "
          >
            In progress
          </p>

          <p
            v-if="
              parseInt((100 * scope.row.finishedLessons) / scope.row.lessons) ==
              0
            "
          >
            NA
          </p>

          <p
            v-if="
              parseInt((100 * scope.row.finishedLessons) / scope.row.lessons) ==
              100
            "
          >
            Done
          </p>
        </template>
      </el-table-column>
    </data-tables>
  </div>
  <div class="row gap-10" v-else>
    <div class="col-12 text-center">
      <img
        style="width: 15%"
        src="@/assets/img/general/ux/no_exams.png"
        alt="No activities"
      />
      <h4 class="no-results-text">{{ lang['no-records'] }}</h4>
    </div>
  </div>
</template>

<script>
import Vue from 'vue';

import { DataTables, DataTablesServer } from 'vue-data-tables';
import { mapState } from 'vuex';

Vue.use(DataTables);
Vue.use(DataTablesServer);

export default {
  data: () => {
    return {
      titles: [{ prop: 'title', label: 'Course' }],
      recordList: [],
      filters: [{ prop: 'title', value: '' }],
      tableProps: { defaultSort: { prop: 'title', order: 'descending' } },
      modal: false
    };
  },
  created() {
    this.getRecords();
  },
  computed: {
    ...mapState(['lang'])
  },
  methods: {
    getRecords() {
      const urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        'course',
        'listing'
      );
      this.$request.get(urlToBeUsedInTheRequest).then(
        (response) => {
          this.recordList = response.data;
        },
        () => {
          this.$errorMessage();
        }
      );
    }
  }
};
</script>
