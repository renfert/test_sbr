<template>
  <div>
    <facebook-loader
      v-if="content == false"
      :speed="2"
      width="700"
      height="200"
      primaryColor="#f0f0f0"
      secondaryColor="#d9d9d9"
    ></facebook-loader>

    <div v-else>
      <div v-if="coursesBelongingToTheGroup != null">
        <div>
          <el-row>
            <el-col :sm="6" :xs="18">
              <el-input
                v-model="table.filters[0].value"
                placeholder="Search"
              ></el-input>
            </el-col>
            <el-col :span="2">
              <el-button
                @click.prevent="addCourse"
                class="sbr-purple"
                icon="el-icon-plus"
                circle
              ></el-button>
            </el-col>
          </el-row>
        </div>
        <data-tables
          :pagination-props="{ background: true, pageSizes: [5] }"
          :data="coursesBelongingToTheGroup"
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
              <el-popconfirm
                confirmButtonText="Ok"
                cancelButtonText="No, Thanks"
                :title="lang['remove-course-question'] + scope.row.title + '?'"
                @onConfirm="removeCourseFromGroup(scope.row.id)"
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

      <el-row v-else class="center m-t-40 m-b-40">
        <el-col :md="24">
          <img
            class="not-found-image"
            src="@/assets/img/general/ux/not_found.png"
          />
          <h4 class="fw-500">
            {{ lang['no-results-courses-in-group'] }}
          </h4>
          <el-button class="sbr-primary" @click="addCourse()">{{
            lang['add-course']
          }}</el-button>
        </el-col>
      </el-row>
    </div>

    <!--------------------
      Add new course modal
    ---------------------->
    <el-dialog
      :visible.sync="modal"
      :title="lang['join-courses']"
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
        <div v-if="coursesNotBelongingToTheGroup != null">
          <template>
            <el-transfer
              filterable
              :titles="['Courses', 'Group']"
              v-model="courses"
              :data="coursesNotBelongingToTheGroup"
            ></el-transfer>
          </template>
          <br />
          <el-button
            v-loading="loading"
            class="sbr-primary"
            @click="saveCourses()"
            >{{ lang['save-button'] }}</el-button
          >
        </div>
        <el-row v-else class="center">
          <el-col>
            <img
              class="not-found-image"
              src="@/assets/img/general/ux/not_found.png"
            />
            <h4>{{ lang['all-courses-already-added'] }}</h4>
          </el-col>
        </el-row>
      </div>
    </el-dialog>
    <!--------------------
      End add new course modal
    ---------------------->
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
        titles: [{ prop: 'title', label: 'Title' }],
        filters: [{ prop: 'title', value: '' }],
        props: { defaultSort: { prop: 'title', order: 'descending' } }
      },
      coursesBelongingToTheGroup: [],
      coursesNotBelongingToTheGroup: [],
      courses: [],
      loading: false,
      modal: false,
      contentModal: false,
      content: false
    };
  },
  created() {
    this.getCoursesThatBelongToGroup();
    this.getCoursesThatNotBelongToGroup();
  },
  computed: {
    ...mapState(['lang'])
  },
  methods: {
    removeCourseFromGroup(courseId) {
      const formData = new FormData();
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'group',
        'removeCourseFromGroup'
      );
      formData.set('courseId', courseId);
      formData.set('groupId', this.groupId);
      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        () => {
          this.getCoursesThatBelongToGroup();
          this.getCoursesThatNotBelongToGroup();
          this.$successMessage();
        },
        () => {
          this.$errorMessage();
        }
      );
    },
    saveCourses() {
      this.loading = true;
      const formData = new FormData();
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'group',
        'saveCoursesIntoGroup'
      );
      formData.set('groupId', this.groupId);
      formData.set('courses', this.courses);
      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        () => {
          this.loading = false;
          this.modal = false;
          this.getCoursesThatBelongToGroup();
          this.getCoursesThatNotBelongToGroup();
          this.courses = [];
        },
        () => {
          this.$errorMessage();
        }
      );
    },
    addCourse() {
      this.modal = true;
    },
    getCoursesThatBelongToGroup() {
      this.content = false;
      const formData = new FormData();
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'group',
        'getCoursesInsideGroup'
      );
      formData.set('groupId', this.groupId);
      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        (response) => {
          this.coursesBelongingToTheGroup = response.data;
          setTimeout(() => {
            this.content = true;
          }, 1000);
        },
        () => {
          this.$errorMessage();
        }
      );
    },
    getCoursesThatNotBelongToGroup() {
      this.contentModal = false;
      const formData = new FormData();
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'group',
        'getCoursesOutsideGroup'
      );
      formData.set('groupId', this.groupId);
      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        (response) => {
          this.coursesNotBelongingToTheGroup = response.data;
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
