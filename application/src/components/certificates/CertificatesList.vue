<template>
  <div class="card-box table-responsive" v-if="certificateList != null">
    <h4>{{ lang['list-certificate'] }}</h4>
    <div style="margin-bottom: 10px">
      <el-row>
        <el-col :span="6">
          <el-input v-model="filters[0].value" placeholder="Search"></el-input>
        </el-col>
      </el-row>
    </div>
    <data-tables
      :pagination-props="{ background: true, pageSizes: [5] }"
      :data="certificateList"
      :filters="filters"
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

  <div class="row m-t-40" v-else>
    <div class="col-12 text-center">
      <img
        class="no-results-img"
        src="@/assets/img/general/ux/certificate.svg"
        alt="No activities"
      />
      <h4 class="no-results-text">{{ lang['no-certificates'] }}</h4>
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
      titles: [
        { prop: 'course', label: 'Course' },
        { prop: 'date', label: 'Date' }
      ],
      filters: [{ prop: 'name', value: '' }],
      tableProps: { defaultSort: { prop: 'name', order: 'descending' } },
      certificateList: [],
      modal: false
    };
  },
  computed: {
    ...mapState(['lang'])
  },
  created() {
    this.getCertificates();
  },
  methods: {
    printCertificate() {},
    getCertificates() {
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'certificate',
        'listing'
      );
      this.$request.get(urlToBeUsedInTheRequest).then(
        (response) => {
          this.certificateList = response.data;
        },
        () => {
          this.$errorMessage();
        }
      );
    }
  }
};
</script>
