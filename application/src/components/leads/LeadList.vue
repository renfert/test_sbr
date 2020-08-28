<template>
  <div class="card-box table-responsive" v-if="leadList != null">
    <facebook-loader
      v-if="loadingContent == true"
      :speed="2"
      width="700"
      primaryColor="#f0f0f0"
      secondaryColor="#d9d9d9"
    ></facebook-loader>

    <div v-else>
      <el-row>
        <el-col :md="6" :xs="16" class="mr-3">
          <el-input v-model="filters[0].value" placeholder="Search"></el-input>
        </el-col>
        <el-col v-if="leadList != null" :span="6">
          <export-excel :data="leadList" name="leads.xls">
            <el-tooltip class="item" effect="dark" :content="lang['export']" placement="top">
              <el-button class="sbr-purple" icon="el-icon-download" circle></el-button>
            </el-tooltip>
          </export-excel>
        </el-col>
      </el-row>
    </div>
    <data-tables
      :pagination-props="{ background: true, pageSizes: [5] }"
      :data="leadList"
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

  <div class="mt-5" v-else>
    <div class="text-center">
      <img class="no-results-img" src="@/assets/img/general/ux/not_found.png" alt="No leads" />
      <h4 class="no-results-text">{{lang["no-leads-found"]}}</h4>
    </div>
  </div>
</template>

<script>
import Vue from "vue";
import axios from "axios";
import VueAxios from "vue-axios";
import domains from "@/mixins/domains";
import alerts from "@/mixins/alerts";
import ElementUI from "element-ui";
import excel from "vue-excel-export";

import { DataTables } from "vue-data-tables";
import { FacebookLoader } from "vue-content-loader";
import { mapState } from "vuex";

Vue.use(excel);
Vue.use(DataTables);
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
        { prop: "email", label: "Email" },
        { prop: "creation_date", label: "Date" }
      ],
      leadList: [],
      filters: [{ prop: "name", value: "" }],
      tableProps: { defaultSort: { prop: "name", order: "descending" } },
      modal: false,
      loadingContent: false
    };
  },
  mounted() {
    this.getLeads();
  },
  computed: {
    ...mapState(["lang"])
  },
  methods: {
    getLeads() {
      this.loadingContent = true;
      var urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        "lead",
        "listing"
      );
      axios.get(urlToBeUsedInTheRequest).then(
        response => {
          // success callback
          this.leadList = response.data;
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
