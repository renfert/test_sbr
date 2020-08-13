<template>
  <div class="col-auto" v-loading="loading">
    <div class="row gap5">
      <div class="col-12 col-md-4 list-programs" v-for="element in programList" :key="element.id">
        <!-- Card -->
        <div class="card">
          <!-- Card image -->
          <img
            v-if="element.expirationDays < 0 || element.releaseDays > 0"
            v-lazy="getUrlToContents() + 'program/'+element.photo+''"
            style="height:200px;cursor:not-allowed;"
            class="card-img-top"
          />
          <router-link v-else :to="'/viewprogram/'+element.id">
            <!-- Card image -->
            <img
              v-lazy="getUrlToContents() + 'program/'+element.photo+''"
              style="height:200px;"
              class="card-img-top"
            />
          </router-link>

          <!-- Card content -->
          <div class="card-body">
            <!-- Title -->
            <h4
              class="card-title"
              v-if="element.expirationDays < 0 || element.releaseDays > 0"
            >{{element.title}}</h4>

            <h4 v-else>
              <router-link class="sbr-text-grey" :to="'/viewprogram/'+element.id">{{element.title}}</router-link>
            </h4>

            <el-progress
              v-if="parseInt(((100 * element.finishedLessons) /  element.lessons )) > 0"
              :percentage="parseInt(((100 * element.finishedLessons) /  element.lessons ))"
            ></el-progress>

            <el-progress v-else :percentage="0"></el-progress>

            <el-tag
              class="mt-2"
              v-if="element.expirationDays < 0"
              type="danger"
            >{{lang["program-expired"]}} {{element.expiration_date}}</el-tag>

            <el-tag
              class="mt-2"
              v-if="element.releaseDays > 0"
              type="primary"
            >{{lang["program-avaiable-in"]}} {{element.release_date}}</el-tag>

            <el-divider v-if="roleId != 3">
              <i class="el-icon-more-outline"></i>
            </el-divider>
            <el-row v-if="roleId != 3">
              <router-link :to="'/editprogram/'+element.id">
                <el-button class="sbr-primary" type="primary" icon="el-icon-edit" circle></el-button>
              </router-link>
              <template>
                <el-popconfirm
                  confirmButtonText="Ok"
                  cancelButtonText="No, Thanks"
                  placement="right"
                  :title="lang['question-delete-program'] + element.title  + '?'"
                  @onConfirm="deleteProgram(element.id)"
                >
                  <el-button
                    class="sbr-danger"
                    slot="reference"
                    type="danger"
                    icon="el-icon-delete"
                    circle
                  ></el-button>
                </el-popconfirm>
              </template>
            </el-row>
          </div>
        </div>
        <!-- Card -->
      </div>
    </div>
  </div>
  <!-- End col-12 -->
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
import alerts from "@/mixins/alerts";
import VueLazyload from "vue-lazyload";
import "element-ui/lib/theme-chalk/index.css";

import { DataTables, DataTablesServer } from "vue-data-tables";
import { mapState } from "vuex";

locale.use(lang);
Vue.use(VueLazyload, {
  preLoad: 1.3,
  error: "https://sbrfiles.s3.amazonaws.com/images/image-not-available.png",
  loading: "https://sbrfiles.s3.amazonaws.com/gifs/loading7.gif",
  attempt: 1
});
Vue.use(DataTables);
Vue.use(DataTablesServer);
Vue.use(ElementUI);
Vue.use(VueAxios, axios);

export default {
  mixins: [domains, alerts],
  data: function() {
    return {
      titles: [{ prop: "title", label: "Title" }],
      programList: [],
      filters: [{ prop: "title", value: "" }],
      tableProps: { defaultSort: { prop: "title", order: "descending" } },
      modal: false,
      loading: false,
      roleId: ""
    };
  },
  created() {
    this.getProgram();
    this.getUserProfile();
  },
  computed: {
    ...mapState(["lang"])
  },
  methods: {
    deleteProgram: function(id) {
      var formData = new FormData();
      formData.set("programId", id);
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        "program",
        "delete"
      );
      axios.post(urlToBeUsedInTheRequest, formData).then(
        () => {
          this.successMessage();
          this.getProgram();
        },
        function() {
          this.errorMessage();
        }.bind(this)
      );
    },
    getProgram() {
      this.loading = true;
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        "program",
        "listing"
      );
      axios.get(urlToBeUsedInTheRequest).then(
        response => {
          // success callback
          this.programList = response.data;
          this.loading = false;
        },
        // Failure callback
        function() {
          this.errorMessage();
        }
      );
    },
    getUserProfile() {
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
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
.list-programs {
  margin-bottom: 50px !important;
}
</style>
