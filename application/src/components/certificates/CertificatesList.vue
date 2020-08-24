<template>
  <div class="col-12">
    <!-- Certificate list -->
    <div class="card-box table-responsive" v-if="certificateList != null">
      <h4>{{ lang["list-certificate"] }}</h4>
      <div style="margin-bottom: 10px">
        <el-row>
          <el-col :span="6">
            <el-input
              v-model="filters[0].value"
              placeholder="Search"
            ></el-input>
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
        >
        </el-table-column>
        <el-table-column label="Actions" align="center">
          <template slot-scope="scope">
            <!-- View certificate -->
            <el-button
              type="primary"
              @click="printCertificate(scope.row.course)"
              size="medium"
              icon="el-icon-edit"
              circle
            ></el-button>
          </template>
        </el-table-column>
      </data-tables>
    </div>

    <div class="row gap-10" v-else>
      <div class="col-12 text-center">
        <img
          style="width:25%;"
          src="@/assets/img/general/ux/no_documents.png"
          alt="No activities"
        />
        <h4 class="no-results-text">{{ lang["no-certificates"] }}</h4>
      </div>
    </div>
  </div>
  <!-- End col-12 -->
</template>

<script>
import Vue from "vue";
import axios from "axios";
import VueAxios from "vue-axios";
import VueTheMask from "vue-the-mask";
import domains from "@/mixins/domains";
import alerts from "@/mixins/alerts";
import { DataTables, DataTablesServer } from "vue-data-tables";
import { eventLang } from "@/components/helper/HelperLang";
import ElementUI from "element-ui";
import "element-ui/lib/theme-chalk/index.css";
import lang from "element-ui/lib/locale/lang/en";
import locale from "element-ui/lib/locale";
locale.use(lang);
Vue.use(DataTables);
Vue.use(DataTablesServer);
Vue.use(ElementUI);
Vue.use(VueTheMask);
Vue.use(VueAxios, axios);
export default {
  mixins: [domains, alerts],
  data: function() {
    return {
      titles: [
        { prop: "course", label: "Course" },
        { prop: "date", label: "Date" }
      ],
      certificateList: [],
      filters: [{ prop: "name", value: "" }],
      tableProps: { defaultSort: { prop: "name", order: "descending" } },
      lang: {},
      modal: false
    };
  },
  created() {
    this.getCertificates();
  },
  mounted() {
    eventLang.$on(
      "lang",
      function(response) {
        this.lang = response;
      }.bind(this)
    );
  },
  methods: {
    printCertificate: function() {},
    getCertificates() {
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        "certificate",
        "listing"
      );
      axios.get(urlToBeUsedInTheRequest).then(
        response => {
          // success callback
          this.certificateList = response.data;
        },
        function() {
          // Failure callback
          this.errorMessage();
        }
      );
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
.gap-10 {
  margin-top: 10%;
}
</style>
