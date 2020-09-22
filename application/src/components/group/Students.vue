<template>
  <div class="m-t-40 m-l-40">
    <facebook-loader
      v-if="content == false"
      :speed="2"
      width="700"
      height="200"
      primaryColor="#f0f0f0"
      secondaryColor="#d9d9d9"
    ></facebook-loader>

    <div v-else>
      <div v-if="studentsBelongingToTheGroup != null">
        <div>
          <el-row :gutter="40">
            <el-col :sm="6" :xs="18">
              <el-input
                v-model="table.filters[0].value"
                placeholder="Search"
              ></el-input>
            </el-col>
            <el-col :span="2">
              <el-button
                @click.prevent="addStudent"
                class="sbr-purple"
                icon="el-icon-plus"
                circle
              ></el-button>
            </el-col>
          </el-row>
        </div>
        <data-tables
          :pagination-props="{ background: true, pageSizes: [5] }"
          :data="studentsBelongingToTheGroup"
          :filters="table.filters"
        >
          <el-table-column
            v-for="title in table.titles"
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
                :title="lang['remove-student-question'] + scope.row.name + '?'"
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
      <el-row v-else class="center m-t-40 m-b-40">
        <el-col :sm="24">
          <img
            class="not-found-image"
            src="@/assets/img/general/ux/students.svg"
          />
          <h4 class="sbr-text-grey">
            {{ lang['no-results-students-in-group'] }}
          </h4>
          <el-button class="sbr-primary" @click="addStudent()">{{
            lang['add-student']
          }}</el-button>
        </el-col>
      </el-row>
      <!-- No Students found content end -->
    </div>

    <!------------------------
      Add new student modal
    ------------------------->
    <el-dialog
      :visible.sync="modal"
      :title="lang['join-students']"
      center
      top="5vh"
    >
      <facebook-loader
        v-if="contentModal == false"
        :speed="2"
        width="700"
        height="200"
        primaryColor="#f0f0f0"
        secondaryColor="#d9d9d9"
      ></facebook-loader>

      <div v-else>
        <div class="center" v-if="studentsNotBelongingToTheGroup != null">
          <template>
            <el-transfer
              filterable
              :titles="['Students', 'Group']"
              v-model="students"
              :data="studentsNotBelongingToTheGroup"
            ></el-transfer>
          </template>
          <br />
          <el-button
            v-loading="loading"
            class="sbr-primary"
            @click="saveStudents()"
            type="primary"
            size="medium"
            >{{ lang['save-button'] }}</el-button
          >
        </div>

        <el-row v-else class="center">
          <el-col :sm="24">
            <img
              class="not-found-image"
              src="@/assets/img/general/ux/students.svg"
            />
            <h4 class="sbr-text-grey">
              {{ lang['all-students-already-added'] }}
            </h4>
          </el-col>
        </el-row>
      </div>
    </el-dialog>
    <!------------------------
      Add new student modal
    ------------------------->
  </div>
</template>

<script>
import Vue from 'vue';

import { FacebookLoader } from 'vue-content-loader';
import { DataTables, DataTablesServer } from 'vue-data-tables';
import { mapState } from 'vuex';

Vue.use(DataTables);
Vue.use(DataTablesServer);

export default {
  components: {
    FacebookLoader
  },
  props: ['group-id'],
  data: () => {
    return {
      table: {
        titles: [{ prop: 'name', label: 'Name' }],
        filters: [{ prop: 'name', value: '' }],
        props: { defaultSort: { prop: 'name', order: 'descending' } }
      },
      studentsBelongingToTheGroup: [],
      studentsNotBelongingToTheGroup: [],
      loading: false,
      content: false,
      contentModal: false,
      modal: false,
      students: []
    };
  },
  created() {
    this.getStudentsThatBelongToGroup();
    this.getStudentsThatNotBelongToGroup();
  },
  computed: {
    ...mapState(['lang'])
  },
  methods: {
    removeStudentFromGroup(studentId) {
      const formData = new FormData();
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'group',
        'removeUserFromGroup'
      );
      formData.set('groupId', this.groupId);
      formData.set('userId', studentId);
      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        () => {
          this.getStudentsThatBelongToGroup();
          this.getStudentsThatNotBelongToGroup();
          this.$successMessage();
        },
        () => {
          this.$errorMessage();
        }
      );
    },
    saveStudents() {
      this.loading = true;
      const formData = new FormData();
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'group',
        'saveUsersIntoGroup'
      );
      formData.set('users', this.students);
      formData.set('groupId', this.groupId);
      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        () => {
          this.loading = false;
          this.modal = false;
          this.getStudentsThatBelongToGroup();
          this.getStudentsThatNotBelongToGroup();
          this.students = [];
        },
        () => {
          this.$errorMessage();
        }
      );
    },
    addStudent() {
      this.modal = true;
    },
    getStudentsThatBelongToGroup() {
      this.content = false;
      const formData = new FormData();
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'group',
        'getStudentsInsideGroup'
      );
      formData.set('groupId', this.groupId);
      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        (response) => {
          this.studentsBelongingToTheGroup = response.data;
          setTimeout(() => {
            this.content = true;
          }, 1000);
        },
        () => {
          this.$errorMessage();
        }
      );
    },
    getStudentsThatNotBelongToGroup() {
      this.contentModal = false;
      const formData = new FormData();
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'group',
        'getStudentsOutsideGroup'
      );
      formData.set('groupId', this.groupId);
      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        (response) => {
          this.studentsNotBelongingToTheGroup = response.data;
          setTimeout(() => {
            this.contentModal = true;
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
