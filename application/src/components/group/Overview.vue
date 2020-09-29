<template>
  <div class="m-t-40 m-l-20 m-r-20">
    <el-row id="top-list" :gutter="20">
      <el-row class="m-b-30 m-l-10">
        <el-col :span="8">
          <el-input
            :placeholder="lang['search']"
            prefix-icon="el-icon-search"
            v-model="search"
          ></el-input>
        </el-col>
      </el-row>
      <el-col v-for="student in visibleUsers" :key="student.id" :sm="8">
        <div class="card-box center">
          <div style="display: flex; justify-content: center">
            <div class="ins_info_thumb">
              <img
                :src="$getUrlToContents() + 'avatar/' + student.avatar + ''"
                class="img-fluid"
              />
            </div>
          </div>
          <div class="m-b-30">
            <h4>{{ student.name }}</h4>
            <span>{{ student.email }}</span>
          </div>
          <el-collapse>
            <el-collapse-item title="Cursos" name="1">
              <div class="courses-list">
                <div
                  v-for="course in coursesBelongingToTheGroup"
                  :key="course.id"
                  class="course-item m-b-20"
                >
                  <span> {{ course.title }}</span>
                  <user-progress
                    :user-id="student.id"
                    :course-id="course.id"
                  ></user-progress>
                </div>
              </div>
            </el-collapse-item>
          </el-collapse>
        </div>
      </el-col>
    </el-row>

    <!-- Pagination -->
    <div
      v-if="
        studentsBelongingToTheGroup != null &&
        studentsBelongingToTheGroup.length > 3
      "
      class="row text-center mb-5"
    >
      <div class="col-12 col-md-12">
        <ul class="pagination p-center">
          <li class="page-item">
            <a
              class="page-link"
              href="javascript:void(0)"
              aria-label="Previous"
            >
              <span class="ti-arrow-left"></span>
              <span class="sr-only">Previous</span>
            </a>
          </li>

          <li
            v-for="pag in parseInt(
              Math.ceil(studentsBelongingToTheGroup.length / perPage)
            )"
            :key="pag"
            class="page-item"
          >
            <a
              class="page-link"
              :class="pag === currentPage ? 'active' : ''"
              @click.prevent="currentPage = pag"
              href="javascript:void(0)"
              >{{ pag }}</a
            >
          </li>
          <li class="page-item">
            <a class="page-link" href="javascript:void(0)" aria-label="Next">
              <span class="ti-arrow-right"></span>
              <span class="sr-only">Next</span>
            </a>
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>

<script>
import Vue from 'vue';

import { DataTables, DataTablesServer } from 'vue-data-tables';
import { mapState } from 'vuex';
import UserProgress from '@/components/group/OverviewStudentProgress';

Vue.use(DataTables);
Vue.use(DataTablesServer);

export default {
  props: ['group-id'],
  data: () => {
    return {
      visibleUsers: null,
      studentsBelongingToTheGroup: [],
      coursesBelongingToTheGroup: [],
      currentPage: 1,
      perPage: 3,
      search: ''
    };
  },
  components: {
    UserProgress
  },
  created() {
    this.getCoursesThatBelongToGroup();
    this.getStudentsThatBelongToGroup();
  },
  computed: {
    ...mapState(['lang'])
  },
  watch: {
    search() {
      this.getStudentsThatBelongToGroup();
    },
    currentPage() {
      this.visibleUsers = this.studentsBelongingToTheGroup.slice(
        (this.currentPage - 1) * this.perPage,
        (this.currentPage - 1) * this.perPage + this.perPage
      );
      document
        .getElementById('top-list')
        .scrollIntoView({ block: 'end', behavior: 'smooth' });
    }
  },
  methods: {
    getPercent() {
      return 30;
    },
    getCoursesThatBelongToGroup() {
      const formData = new FormData();
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'group',
        'getCoursesInsideGroup'
      );
      formData.set('groupId', this.groupId);
      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        (response) => {
          this.coursesBelongingToTheGroup = response.data;
        },
        () => {
          this.$errorMessage();
        }
      );
    },
    getStudentsThatBelongToGroup() {
      const formData = new FormData();
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'group',
        'getStudentsInsideGroup'
      );
      formData.set('groupId', this.groupId);
      formData.set('email', this.search);
      this.$request.post(urlToBeUsedInTheRequest, formData).then(
        (response) => {
          this.studentsBelongingToTheGroup = response.data;
          this.visibleUsers = response.data.slice(
            (this.currentPage - 1) * this.perPage,
            (this.currentPage - 1) * this.perPage + this.perPage
          );
        },
        () => {
          this.$errorMessage();
        }
      );
    }
  }
};
</script>

<style scoped>
.courses-list {
  text-align: left;
  width: 100%;
}

.course-item {
  background-color: #f8f8ff;
  padding: 10px;
  border-radius: 5px;
  width: 100%;
}
</style>
