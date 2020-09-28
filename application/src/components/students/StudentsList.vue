<template>
  <div class="card-box" v-if="studentsList != null">
    <facebook-loader
      v-if="content == false"
      :speed="2"
      width="700"
      primaryColor="#f0f0f0"
      secondaryColor="#d9d9d9"
    ></facebook-loader>

    <div v-else>
      <el-row>
        <el-col :sm="6" :xs="16" class="mr-3">
          <el-input
            v-model="table.filters[0].value"
            placeholder="Search"
          ></el-input>
        </el-col>
        <el-col v-if="studentsList != null" :span="6">
          <export-excel :data="studentsList" name="students.xls">
            <el-tooltip
              class="item"
              effect="dark"
              :content="lang['export']"
              placement="top"
            >
              <el-button
                class="sbr-purple"
                icon="el-icon-download"
                circle
              ></el-button>
            </el-tooltip>
          </export-excel>
        </el-col>
      </el-row>
    </div>
    <data-tables
      :pagination-props="{ background: true, pageSizes: [5] }"
      :data="studentsList"
      :filters="table.filters"
    >
      <el-table-column align="center">
        <template slot-scope="scope">
          <div class="ins_info_thumb">
            <img
              :src="$getUrlToContents() + 'avatar/' + scope.row.avatar + ''"
              class="img-fluid"
            />
          </div>
        </template>
      </el-table-column>
      <el-table-column
        v-for="title in table.titles"
        sortable="custom"
        :prop="title.prop"
        :label="title.label"
        :key="title.label"
      ></el-table-column>
    </data-tables>
  </div>

  <div class="m-t-40 center" v-else>
    <img
      class="not-found-image"
      src="@/assets/img/general/ux/students.svg"
      alt="No leads"
    />
    <h4 class="sbr-text-grey">{{ lang['no-students-found'] }}</h4>
  </div>
</template>

<script>
import Vue from 'vue';
import excel from 'vue-excel-export';

import { DataTables } from 'vue-data-tables';
import { FacebookLoader } from 'vue-content-loader';
import { mapState } from 'vuex';

Vue.use(excel);
Vue.use(DataTables);

export default {
  components: {
    FacebookLoader
  },
  data: () => {
    return {
      table: {
        titles: [
          { prop: 'name', label: 'Name' },
          { prop: 'email', label: 'Email' }
        ],
        filters: [{ prop: 'name', value: '' }],
        props: { defaultSort: { prop: 'name', order: 'descending' } }
      },
      studentsList: [],
      modal: false,
      content: false
    };
  },
  mounted() {
    this.getStudents();
  },
  computed: {
    ...mapState(['lang'])
  },
  methods: {
    getStudents() {
      this.content = false;
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'user',
        'getStudents'
      );
      this.$request.get(urlToBeUsedInTheRequest).then(
        (response) => {
          this.studentsList = response.data;
          setTimeout(() => {
            this.content = true;
          }, 1000);
        },
        () => {
          this.$errorMessage();
        }
      );
    }
  }
};
</script>
