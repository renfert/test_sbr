<template>
  <div class="card-box table-responsive" v-if="userList != null">
    <facebook-loader
      v-if="loadingContent == true"
      :speed="2"
      width="700"
      primaryColor="#f0f0f0"
      secondaryColor="#d9d9d9"
    ></facebook-loader>

    <div v-else>
      <div>
        <h4>{{ lang["list-users"] }}</h4>
        <div style="margin-bottom: 10px">
          <el-row>
            <el-col :md="6" :xs="16">
              <el-input v-model="filters[0].value" placeholder="Search"></el-input>
            </el-col>
            <el-col v-if="userList != null" :span="6">
              <export-excel :data="userList" name="users.xls">
                <el-tooltip class="item" effect="dark" :content="lang['export']" placement="top">
                  <el-button class="sbr-purple ml-3" type="primary" icon="el-icon-download" circle></el-button>
                </el-tooltip>
              </export-excel>
            </el-col>
          </el-row>
        </div>
        <data-tables
          :pagination-props="{ background: true, pageSizes: [5] }"
          :data="userList"
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
              <!-- Manage user -->
              <router-link :to="'/user/'+scope.row.id">
                <el-button size="small" class="sbr-primary" icon="el-icon-user" circle></el-button>
              </router-link>

              <!-- Delete User -->
              <el-popconfirm
                confirmButtonText="Ok"
                cancelButtonText="No, Thanks"
                placement="right"
                :title="lang['question-delete-user'] + scope.row.name + '?'"
                @onConfirm="deleteUser(scope.row.id)"
              >
                <el-button
                  size="small"
                  class="sbr-danger ml-1"
                  slot="reference"
                  icon="el-icon-delete"
                  circle
                ></el-button>
              </el-popconfirm>
            </template>
          </el-table-column>
        </data-tables>
      </div>
    </div>
  </div>
  <!-- End User list -->

  <div class="row mb-5 mt-5" v-else>
    <div class="col-12 text-center">
      <img class="no-results-img" src="@/assets/img/general/ux/no_persons.png" alt="No persons" />
      <h4 class="no-results-text">{{ lang["no-results-user-title"] }}</h4>
    </div>
  </div>
</template>

<script>
import Vue from "vue";
import axios from "axios";
import VueAxios from "vue-axios";
import ElementUI from "element-ui";
import excel from "vue-excel-export";
import domains from "@/mixins/domains";
import alerts from "@/mixins/alerts";
import { FacebookLoader } from "vue-content-loader";

import { DataTables, DataTablesServer } from "vue-data-tables";
import { eventBus } from "@/components/users/App";
import { mapState } from "vuex";

Vue.use(excel);
Vue.use(DataTables);
Vue.use(DataTablesServer);
Vue.use(ElementUI);
Vue.use(VueAxios, axios);

export default {
  components: {
    FacebookLoader
  },
  mixins: [domains, alerts],
  data: function() {
    return {
      titles: [
        { prop: "name", label: "Name" },
        { prop: "role", label: "Role" }
      ],
      userList: [],
      filters: [{ prop: "name", value: "" }],
      tableProps: { defaultSort: { prop: "name", order: "descending" } },
      loadingContent: false
    };
  },
  created() {
    this.getUsers();
    eventBus.$on(
      "new-user",
      function() {
        this.getUsers();
      }.bind(this)
    );
  },
  computed: {
    ...mapState(["lang"])
  },
  methods: {
    deleteUser(id) {
      var formData = new FormData();
      formData.set("id", id);
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("user", "delete");
      axios.post(urlToBeUsedInTheRequest, formData).then(
        () => {
          // success callback
          this.successMessage();
          this.getUsers();
        },
        // Failure callback
        function() {
          this.errorMessage();
        }.bind(this)
      );
    },
    getUsers() {
      this.loadingContent = true;
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest("user", "listing");
      axios.get(urlToBeUsedInTheRequest).then(
        response => {
          // success callback
          this.userList = response.data;
          setTimeout(
            function() {
              this.loadingContent = false;
            }.bind(this),
            1000
          );
        },
        // Failure callback
        function() {
          this.errorMessage();
        }.bind(this)
      );
    }
  }
};
</script>
