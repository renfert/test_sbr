<template>
  <div class="col-auto">
    <h4>{{lang["list-course"]}}</h4>
    <div style="margin-bottom: 10px">
      <el-row>
        <el-col :xs="16" :lg="6">
          <el-input v-model="filters[0].value" placeholder="Search"></el-input>
        </el-col>
        <el-col v-if="courseList != null" :span="6">
          <export-excel :data="courseList" name="courses.xls">
            <el-tooltip class="item" effect="dark" :content="lang['export']" placement="top">
              <el-button class="sbr-purple ml-3" type="primary" icon="el-icon-download" circle></el-button>
            </el-tooltip>
          </export-excel>
        </el-col>
      </el-row>
    </div>
    <data-tables
      :pagination-props="{ background: true, pageSizes: [5] }"
      :data="courseList"
      :filters="filters"
    >
      <el-table-column
        v-for="title in titles"
        sortable="custom"
        :prop="title.prop"
        :label="title.label"
        :key="title.label"
      ></el-table-column>

      <el-table-column label="Actions" align="center">
        <template slot-scope="scope">
          <router-link :to="'/editcourse/'+scope.row.id">
            <el-button
              size="small"
              class="sbr-primary mt-2"
              v-if="roleId != 3"
              type="primary"
              icon="el-icon-edit"
              circle
            ></el-button>
          </router-link>
          <router-link :to="'/viewcourse/'+scope.row.id">
            <el-button
              size="small"
              class="sbr-secondary"
              type="success"
              icon="el-icon-video-play"
              circle
            ></el-button>
          </router-link>
        </template>
      </el-table-column>
    </data-tables>
  </div>
  <!-- End col-auto -->
</template>

<script>
import Vue from "vue";
import axios from "axios";
import VueAxios from "vue-axios";
import ElementUI from "element-ui";
import "element-ui/lib/theme-chalk/index.css";
import lang from "element-ui/lib/locale/lang/en";
import locale from "element-ui/lib/locale";
import domains from "@/mixins/domains";
import excel from "vue-excel-export";
import alerts from "@/mixins/alerts";

import { DataTables, DataTablesServer } from "vue-data-tables";
import { mapState } from "vuex";

locale.use(lang);

Vue.use(excel);
Vue.use(DataTables);
Vue.use(DataTablesServer);
Vue.use(ElementUI);
Vue.use(VueAxios, axios);

export default {
  mixins: [domains, alerts],
  data: function() {
    return {
      titles: [{ prop: "title", label: "Title" }],
      courseList: [],
      filters: [{ prop: "title", value: "" }],
      tableProps: { defaultSort: { prop: "title", order: "descending" } },
      roleId: ""
    };
  },
  computed: {
    ...mapState(["lang"])
  },
  created() {
    this.updateCourseListArray();
    this.getUserProfile();
  },
  methods: {
    updateCourseListArray() {
      this.loading = true;
      var urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        "course",
        "listing"
      );
      axios.get(urlToBeUsedInTheRequest).then(
        response => {
          // success callback
          this.courseList = response.data;
          this.loading = false;
        },
        // Failure callback
        function() {
          this.errorMessage();
        }
      );
    },
    getUserProfile() {
      var urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        "user",
        "getUserProfile"
      );
      axios.get(urlToBeUsedInTheRequest).then(
        function(response) {
          this.roleId = response.data["myrole_id"];
        }.bind(this)
      );
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
</style>
