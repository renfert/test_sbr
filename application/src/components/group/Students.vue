<template>
  <div class="m-5">
    <facebook-loader
      v-if="loadingContent == true"
      :speed="2"
      width="700"
      height="200"
      primaryColor="#f0f0f0"
      secondaryColor="#d9d9d9"
    ></facebook-loader>

    <div v-else>
      <!-- Students list  -->
      <div class="course-content" v-if="studentsInsideGroup != null">
        <div class="mb-5">
          <el-row>
            <el-col :md="6" :xs="18" class="mr-3">
              <el-input v-model="filters[0].value" placeholder="Search"></el-input>
            </el-col>
            <el-col :span="2">
              <el-button @click.prevent="addStudent" class="sbr-purple" icon="el-icon-plus" circle></el-button>
            </el-col>
          </el-row>
        </div>
        <data-tables
          :pagination-props="{ background: true, pageSizes: [5] }"
          :data="studentsInsideGroup"
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
              <!-- Remove course -->
              <el-popconfirm
                confirmButtonText="Ok"
                cancelButtonText="No, Thanks"
                :title="lang['remove-student-question'] + scope.row.name  + '?'"
                @onConfirm="removeStudentFromGroup(scope.row.id)"
              >
                <el-button
                  class="sbr-danger"
                  size="small"
                  slot="reference"
                  icon="el-icon-delete"
                  circle
                ></el-button>
              </el-popconfirm>
            </template>
          </el-table-column>
        </data-tables>
      </div>
      <!-- Students list content -->

      <!-- No students found  -->
      <div v-else>
        <div class="row mb-5">
          <div class="col-12 text-center">
            <img
              class="no-results-img"
              src="@/assets/img/general/ux/not_found.png"
              alt="No activities"
            />
            <h4 class="no-results-text mb-3">{{lang["no-results-students-in-group"]}}</h4>
            <el-button class="sbr-primary" @click="addStudent()">{{lang["add-student"]}}</el-button>
          </div>
        </div>
      </div>
      <!-- No Students found content end -->
    </div>

    <!-- Add new student dialog -->
    <el-dialog :visible.sync="modal" :title="lang['join-students']" center top="5vh">
      <facebook-loader
        v-if="loadingContentModal == true"
        :speed="2"
        width="700"
        height="200"
        primaryColor="#f0f0f0"
        secondaryColor="#d9d9d9"
      ></facebook-loader>

      <div v-else>
        <div v-if="studentsOutsideGroup != null">
          <template>
            <el-transfer
              filterable
              :titles="['Students', 'Group']"
              v-model="students"
              :data="studentsOutsideGroup"
            ></el-transfer>
          </template>
          <br />
          <el-button
            v-loading="loadingButton"
            class="sbr-primary"
            @click="saveStudents()"
            type="primary"
            size="medium"
          >{{lang["save-button"]}}</el-button>
        </div>

        <!-- No students found  -->
        <div v-else>
          <div class="row mb-5">
            <div class="col-12 text-center">
              <img
                class="no-results-img"
                src="@/assets/img/general/ux/not_found.png"
                alt="No activities"
              />
              <h4>{{lang["all-students-already-added"]}}</h4>
            </div>
          </div>
        </div>
        <!-- No Students found content end -->
      </div>
    </el-dialog>
  </div>
  <!-- End col-auto -->
</template>

<script>
import Vue from "vue";
import axios from "axios";
import VueAxios from "vue-axios";
import ElementUI from "element-ui";
import domains from "@/mixins/domains";
import alerts from "@/mixins/alerts";

import { FacebookLoader } from "vue-content-loader";
import { DataTables, DataTablesServer } from "vue-data-tables";
import { mapState } from "vuex";

Vue.use(DataTables);
Vue.use(DataTablesServer);
Vue.use(ElementUI);
Vue.use(VueAxios, axios);

export default {
  components: {
    FacebookLoader
  },
  mixins: [domains, alerts],
  props: ["group-id"],
  data: function() {
    return {
      titles: [{ prop: "name", label: "Name" }],
      studentsInsideGroup: [],
      studentsOutsideGroup: [],
      filters: [{ prop: "name", value: "" }],
      tableProps: { defaultSort: { prop: "name", order: "descending" } },
      loadingButton: false,
      loadingContent: false,
      loadingContentModal: false,
      modal: false,
      students: []
    };
  },
  created() {
    this.getStudentsInsideTheGroup();
    this.getStudentsOutsideTheGroup();
  },
  computed: {
    ...mapState(["lang"])
  },
  methods: {
    removeStudentFromGroup: function(studentId) {
      var formData = new FormData();
      formData.set("userId", studentId);
      formData.set("groupId", this.groupId);
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        "group",
        "removeUserFromGroup"
      );
      axios.post(urlToBeUsedInTheRequest, formData).then(
        () => {
          // success callback
          this.getStudentsInsideTheGroup();
          this.getStudentsOutsideTheGroup();
          this.successMessage();
        },
        // Failure callback
        function() {
          this.errorMessage();
        }
      );
    },
    saveStudents: function() {
      this.loadingButton = true;
      var formData = new FormData();
      formData.set("groupId", this.groupId);
      formData.set("users", this.students);
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        "group",
        "saveUsersIntoGroup"
      );
      axios.post(urlToBeUsedInTheRequest, formData).then(
        () => {
          // success callback
          this.loadingButton = false;
          this.modal = false;
          this.getStudentsInsideTheGroup();
          this.getStudentsOutsideTheGroup();
          this.students = [];
        },
        // Failure callback
        function() {
          this.errorMessage();
        }.bind(this)
      );
    },
    addStudent: function() {
      this.modal = true;
    },
    getStudentsInsideTheGroup() {
      this.loadingContent = true;
      var formData = new FormData();
      formData.set("groupId", this.groupId);
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        "group",
        "getStudentsInsideGroup"
      );
      axios.post(urlToBeUsedInTheRequest, formData).then(
        response => {
          // success callback
          this.studentsInsideGroup = response.data;
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
    },
    getStudentsOutsideTheGroup: function() {
      this.loadingContentModal = true;
      var formData = new FormData();
      formData.set("groupId", this.groupId);
      var urlToBeUsedInTheRequest = this.getUrlToMakeRequest(
        "group",
        "getStudentsOutsideGroup"
      );
      axios.post(urlToBeUsedInTheRequest, formData).then(
        response => {
          // success callback
          this.studentsOutsideGroup = response.data;
          setTimeout(
            function() {
              this.loadingContentModal = false;
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

