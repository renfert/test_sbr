<template>
  <div class="card-box m-t-30" v-if="courseList != null">
    <el-row class="m-b-40">
      <div>
        <a
          @click="changeCourseVisualization()"
          href="javascript:void(0)"
          class="dropdown-toggle arrow-none card-drop float-right"
          data-toggle="dropdown"
          aria-expanded="false"
        >
          <i
            v-if="courseVisualization == 'list'"
            class="mdi mdi-view-list mdi-36px pr-4 sbr-text-grey"
          ></i>
          <i v-else class="mdi mdi-table mdi-36px pr-4 sbr-text-grey"></i>
        </a>
      </div>
    </el-row>
    <course-list-view v-if="courseVisualization == 'list'"></course-list-view>
    <course-table-view v-else></course-table-view>
  </div>

  <el-row v-else class="center m-t-40">
    <el-col>
      <img
        class="not-found-image"
        src="@/assets/img/general/ux/no_courses.svg"
      />
      <h4 class="no-results-text">{{ lang['no-courses-found'] }}</h4>
      <router-link v-if="user.role != 3" to="/newcourse">
        <el-button class="sbr-primary mt-4">{{
          lang['new-course-button']
        }}</el-button>
      </router-link>
    </el-col>
  </el-row>
</template>

<script>
import CourseListView from '@/components/courses/views/CourseListView';
import CourseTableView from '@/components/courses/views/CourseTableView';

import { eventBus } from '@/components/courses/App';
import { mapState } from 'vuex';

export default {
  components: {
    CourseListView,
    CourseTableView
  },
  computed: {
    ...mapState(['lang'])
  },
  data: () => {
    return {
      courseList: [],
      courseVisualization: 'list'
    };
  },
  created() {
    this.getCourses();
  },
  mounted() {
    eventBus.$on('course-deleted', () => {
      this.getCourses();
    });
  },
  methods: {
    changeCourseVisualization() {
      this.courseVisualization === 'list'
        ? (this.courseVisualization = 'table')
        : (this.courseVisualization = 'list');
    },
    getCourses() {
      const urlToBeUsedInTheRequest = this.$getUrlToMakeRequest(
        'course',
        'listing'
      );
      this.$request.get(urlToBeUsedInTheRequest).then(
        (response) => {
          this.courseList = response.data;
        },
        () => {
          this.$errorMessage();
        }
      );
    }
  }
};
</script>
