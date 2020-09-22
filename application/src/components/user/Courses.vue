<template>
  <div class="m-t-40 m-l-40">
    <facebook-loader
      v-if="loadingContent == true"
      :speed="2"
      width="700"
      height="200"
      primaryColor="#f0f0f0"
      secondaryColor="#d9d9d9"
    ></facebook-loader>

    <div v-else class="m-b-40">
      <!-- Courses list content -->
      <div class="course-content" v-if="enrolledCourses != null">
        <div>
          <el-row>
            <el-col :md="6" :xs="18">
              <el-input
                v-model="filters[0].value"
                placeholder="Search"
              ></el-input>
            </el-col>
            <el-col :span="2">
              <el-button
                @click.prevent="addCourse()"
                class="sbr-purple"
                icon="el-icon-plus"
                circle
              ></el-button>
            </el-col>
          </el-row>
        </div>
        <data-tables
          :pagination-props="{ background: true, pageSizes: [5] }"
          :data="enrolledCourses"
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
                :title="lang['remove-course-question'] + scope.row.title + '?'"
                @onConfirm="removeCourseFromUser(scope.row.id)"
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
      <!-- Courses list content -->

      <!--------------
      Courses not found
      --------------->
      <el-row v-else>
        <div class="text-center m-t-40">
          <img
            class="not-found-image"
            src="@/assets/img/general/ux/no_courses.svg"
          />
          <br />
          <h4 class="sbr-text-grey">
            {{ lang['no-results-courses-in-user'] }}
          </h4>
          <el-button class="sbr-purple" @click="addCourse()" type="primary">{{
            lang['add-course']
          }}</el-button>
        </div>
      </el-row>
    </div>

    <!-- Add new course dialog -->
    <el-dialog
      :visible.sync="modal"
      :title="lang['join-courses']"
      center
      top="5vh"
    >
      <facebook-loader
        v-if="loadingContentModal == true"
        :speed="2"
        width="700"
        height="200"
        primaryColor="#f0f0f0"
        secondaryColor="#d9d9d9"
      ></facebook-loader>

      <div v-else>
        <div v-if="notEnrolledCourses != null" class="center">
          <template>
            <el-transfer
              filterable
              :titles="['Courses', 'User']"
              v-model="courses"
              :data="notEnrolledCourses"
            ></el-transfer>
          </template>
          <br />
          <el-button
            class="sbr-primary"
            v-loading="loadingButton"
            @click="enrollUserIntoCourses()"
            type="primary"
            >{{ lang['save-button'] }}</el-button
          >
        </div>

        <div class="row mb-5 mt-5" v-else>
          <div class="col-12 text-center">
            <img
              class="no-results-img"
              src="@/assets/img/general/ux/no_courses.svg"
              alt="No courses"
            />
            <h4 class="no-results-text">
              {{ lang['all-courses-already-added'] }}
            </h4>
          </div>
        </div>
      </div>
    </el-dialog>
  </div>
  <!-- End col-auto -->
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
  props: ['user-id'],
  data: () => {
    return {
      titles: [{ prop: 'title', label: 'Title' }],
      enrolledCourses: [],
      notEnrolledCourses: [],
      filters: [{ prop: 'title', value: '' }],
      tableProps: { defaultSort: { prop: 'title', order: 'descending' } },
      modal: false,
      courses: [],
      loadingButton: false,
      loadingContent: false,
      loadingContentModal: false
    };
  },
  created() {
    this.getEnrolledCourses();
    this.getNotEnrolledCourses();
  },
  computed: {
    ...mapState(['lang'])
  },
  methods: {
    removeCourseFromUser(courseId) {
      const formData = new FormData();
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'user',
        'removeCourseFromUser'
      );
      formData.set('courseId', courseId);
      formData.set('userId', this.userId);
      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        () => {
          this.getEnrolledCourses();
          this.getNotEnrolledCourses();
          this.$successMessage();
        },
        () => {
          this.$errorMessage();
        }
      );
    },

    addCourse() {
      this.modal = true;
    },
    enrollUserIntoCourses() {
      this.loadingButton = true;
      const formData = new FormData();
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'user',
        'enrollUserIntoCourses'
      );
      formData.set('userId', this.userId);
      formData.set('courses', this.courses);
      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        () => {
          this.loadingButton = false;
          this.$successMessage();
          this.modal = false;
          this.getEnrolledCourses();
          this.getNotEnrolledCourses();
          this.courses = [];
        },
        () => {
          this.$errorMessage();
        }
      );
    },
    getEnrolledCourses() {
      this.loadingContent = true;
      const formData = new FormData();
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'user',
        'getEnrolledCourses'
      );
      formData.set('userId', this.userId);
      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        (response) => {
          this.enrolledCourses = response.data;
          setTimeout(() => {
            this.loadingContent = false;
          }, 1000);
        },
        () => {
          this.$errorMessage();
        }
      );
    },
    getNotEnrolledCourses() {
      this.loadingContentModal = true;
      const formData = new FormData();
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'user',
        'getNotEnrolledCourses'
      );
      formData.set('userId', this.userId);
      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        (response) => {
          this.notEnrolledCourses = response.data;
          setTimeout(() => {
            this.loadingContentModal = false;
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
